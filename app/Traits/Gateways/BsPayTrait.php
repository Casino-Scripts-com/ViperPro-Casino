<?php

namespace App\Traits\Gateways;

use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

trait BsPayTrait
{
    /**
     * @var $uri
     * @var $clienteId
     * @var $clienteSecret
     */
    protected static string $uri;
    protected static string $clienteId;
    protected static string $clienteSecret;
    protected static string $statusCode;
    protected static string $errorBody;

    /**
     * Generate Credentials
     * Metodo para gerar credenciais
     * @return void
     */
    private static function generateCredentials()
    {
        $setting = Gateway::first();
        if(!empty($setting)) {
            self::$uri = $setting->bspay_uri;
            self::$clienteId = $setting->bspay_cliente_id;
            self::$clienteSecret = $setting->bspay_cliente_secret;

            return self::authentication();
        }

        return false;
    }

    /**
     * Authentication
     *
     * @return false
     */
    private static function authentication()
    {
        $client_id      = self::$clienteId;
        $client_secret  = self::$clienteSecret;
        $credentials = base64_encode($client_id . ":" . $client_secret);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])
            ->post(self::$uri.'authentication', [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['access_token'];
        } else {
            self::$statusCode = $response->status();
            self::$errorBody = $response->body();
            return false;
        }
    }

    /**
     * Request QRCODE
     * Metodo para solicitar uma QRCODE PIX
     * @return array
     */
    public static function requestQrcode($request)
    {
        if($access_token = self::generateCredentials()) {
            $setting = \Helper::getSetting();
            $rules = [
                'amount' => ['required', 'max:'.$setting->min_deposit, 'max:'.$setting->max_deposit],
                'cpf'    => ['required', 'max:255'],
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $parameters = [
                'amount' => \Helper::amountPrepare($request->amount),
                "external_id" => auth()->user()->id,
                "payerQuestion" => "Pagamento referente ao serviço/produto X",
                "payer" => [
                    "name" => auth()->user()->name,
                    "document" => \Helper::soNumero($request->cpf)
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ])->post(self::$uri.'payment/pix/create', $parameters);

            if ($response->successful()) {
                $responseData = $response->json();

                self::generateTransaction($responseData['transactionId'], \Helper::amountPrepare($request->amount)); /// gerando historico
                self::generateDeposit($responseData['transactionId'], \Helper::amountPrepare($request->amount)); /// gerando deposito

                return [
                    'status' => true,
                    'idTransaction' => $responseData['transactionId'],
                    'qrcode' => $responseData['emvqrcps']
                ];
            } else {
                self::$statusCode = $response->status();
                self::$errorBody = $response->body();
                return false;
            }
        }
    }

    /**
     * @param $idTransaction
     * @param $amount
     * @return void
     */
    private static function generateDeposit($idTransaction, $amount)
    {
        Deposit::create([
            'payment_id' => $idTransaction,
            'user_id' => auth()->user()->id,
            'amount' => $amount,
            'type' => 'pix',
            'status' => 0
        ]);
    }

    /**
     * @param $idTransaction
     * @param $amount
     * @return void
     */
    private static function generateTransaction($idTransaction, $amount)
    {
        $setting = \Helper::getSetting();

        Transaction::create([
            'payment_id' => $idTransaction,
            'user_id' => auth()->user()->id,
            'payment_method' => 'pix',
            'price' => $amount,
            'currency' => $setting->currency_code,
            'status' => 0
        ]);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function consultStatusTransaction($request)
    {
        $transaction = Transaction::where('payment_id', $request->idTransaction)->where('status', 1)->first();
        if(!empty($transaction)) {
            self::FinishTransaction($transaction->price, $transaction->user_id);
            return response()->json(['status' => 'PAID']);
        }

        return response()->json(['status' => 'NOPAID'], 400);
    }

    /**
     * @param $price
     * @param $userId
     * @return void
     */
    public static function FinishTransaction($price, $userId)
    {
        $setting = Setting::first();
        $wallet = Wallet::where('user_id', $userId)->first();
        if(!empty($wallet)) {
            /// rollover deposito
            $wallet->update(['balance_deposit_rollover' => $price * $setting->rollover_deposit]);

            /// acumular bonus
            \Helper::payBonusVip($wallet, $price);
        }
    }

    /**
     * Make Payment
     *
     * @param array $array
     * @return false
     */
    public static function MakePayment(array $array)
    {
        if($access_token = self::generateCredentials()) {

            $pixKey     = $array['pix_key'];
            $pixType    = self::FormatPixType($array['pix_type']);
            $amount     = $array['amount'];
            $doc        = \Helper::soNumero($array['document']);

            $parameters = [
                'amount' => floatval(\Helper::amountPrepare($amount)),
                "external_id" => $array['payment_id'],
                "payerQuestion" => "Fazendo pagamento.",
                "payer" => [
                    "key" => $pixKey,
                    "keyType" => $pixType,
                    "document" => $doc
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
            ])->post(self::$uri.'payment/pix/send', $parameters);

            if ($response->successful()) {
                $responseData = $response->json();

                if($responseData['status'] === 'PROCESSING') {
                    $withdrawal = Withdrawal::find($array['payment_id']);
                    if(!empty($withdrawal)) {
                        $deposit = Deposit::where('payment_id',  $responseData['transactionId'])->first();
                        if(!empty($deposit)) {
                            $deposit->update(['status' => 1]);
                        }

                        $withdrawal->update([
                            'proof' => $responseData['transactionId'],
                            'status' => 1,
                        ]);
                        return true;
                    }
                    return false;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    /**
     * @param $type
     * @return string|void
     */
    private static function FormatPixType($type)
    {
        switch ($type) {
            case 'email':
                return 'EMAIL';
            case 'document':
                return 'CPF';
            case 'document':
                return 'CNPJ';
            case 'randomKey':
                return 'ALEATORIA';
            case 'phoneNumber':
                return 'TELEFONE';
        }
    }
}
