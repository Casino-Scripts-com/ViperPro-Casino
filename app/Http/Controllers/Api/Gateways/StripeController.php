<?php

namespace App\Http\Controllers\Api\Gateways;

use App\Models\Currency;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Traits\Gateways\StripeTrait;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    use StripeTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSessionRequest(Request $request)
    {
        try {
            return self::stripeSession($request->amount, $request->currency);
        }catch (\Exception $e) {
            return response()->json(['status' => false, 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(Request $request)
    {
        try {
            return $this->stripePayment($request);
        }catch (\Exception $e) {
            return response()->json(['status' => false, 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * Stripe Payment
     *
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    private function stripePayment(Request $request)
    {

    }

    /**
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function getPublicKey()
    {
        $stripe = Gateway::first();
        if(!empty($stripe)) {
            return response()->json(['stripe_public_key' => $stripe->stripe_public_key, 'stripe_secret_key' => $stripe->stripe_secret_key, 'successURL' => url('stripe/success')]);
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    public function webhooks(Request $request)
    {
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            http_response_code(400);
            exit();
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
                if(!empty($paymentIntent['client_reference_id'])) {
                    $user = User::find($paymentIntent['client_reference_id']);
                    if(!empty($user)) {
                        $array = [
                            'payment_intent' => $paymentIntent['payment_intent'],
                            'status' => $paymentIntent['payment_status'],
                            'currency' => $paymentIntent['currency'],
                            'amount' => $paymentIntent['amount_total'] / 100,
                        ];

                        //\DB::table('debug')->insert(['text' => json_encode($array)]);
                        if($paymentIntent['payment_status'] == 'paid') {
                            $amount = $paymentIntent['amount_total'] / 100;
                            self::generateTransaction($paymentIntent['payment_intent'], $user->id, $amount); /// gerando historico
                            self::generateDeposit($paymentIntent['payment_intent'], $user->id, $amount); /// gerando deposito

                            $wallet = Wallet::where('user_id', $user->id)->first();

                            /// verificar se a wallet ativa é da mesma moeda
                            if(strtolower($user->wallet->currency) == strtolower($paymentIntent['currency'])) {
                                $wallet->increment('balance', intval($amount));
                                $wallet->update(['active' => 1]);
                            }else{
                                $wallet->update(['active' => 0]); /// desativa a carteira
                                ///
                                $currency = Currency::where('code', strtoupper($paymentIntent['currency']))->first();

                                /// cria uma nova ativa
                                Wallet::create([
                                    'user_id'   => $user->id,
                                    'balance'   => $amount,
                                    'currency'  => $currency->code,
                                    'symbol'    => $currency->symbol,
                                    'active'    => 1
                                ]);
                            }
                        }
                    }
                }

                break;
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent


                break;
            case 'payment_method.attached':
                $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
                //\DB::table('debug')->insert(['text' => json_encode($paymentMethod)]);

                break;
            default:
                echo 'Received unknown event type ' . $event->type;
        }
    }


    /**
     * @param $idTransaction
     * @param $amount
     * @return void
     */
    private static function generateDeposit($idTransaction, $userId, $amount)
    {
        $wallet = Wallet::where('user_id', $userId)->first();

        Deposit::create([
            'payment_id' => $idTransaction,
            'user_id' => $userId,
            'amount' => $amount,
            'type' => 'Stripe',
            'currency' => $wallet->currency,
            'symbol' => $wallet->symbol,
            'status' => 0
        ]);
    }

    /**
     * @param $idTransaction
     * @param $amount
     * @return void
     */
    private static function generateTransaction($idTransaction, $userId, $amount)
    {
        $setting = \Helper::getSetting();

        Transaction::create([
            'payment_id' => $idTransaction,
            'user_id' => $userId,
            'payment_method' => 'stripe',
            'price' => $amount,
            'currency' => $setting->currency_code,
            'status' => 1
        ]);
    }
}
