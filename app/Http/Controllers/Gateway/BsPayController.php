<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Traits\Affiliates\AffiliateHistoryTrait;
use App\Traits\Gateways\BsPayTrait;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class BsPayController extends Controller
{
    use BsPayTrait, AffiliateHistoryTrait;


    /**
     * @dev victormsalatiel
     * @param Request $request
     * @return null
     */
    public function getQRCodePix(Request $request)
    {
        return self::requestQrcode($request);
    }

    /**
     * Store a newly created resource in storage.
     * @dev victormsalatiel
     */
    public function callbackMethod(Request $request)
    {
        ///\DB::table('debug')->insert(['text' => json_encode($request->all())]);

        if(isset($request->transactionId) && $request->transactionType == 'RECEIVEPIX') {
            $transaction = Transaction::where('payment_id', $request->transactionId)->where('status', 0)->first();
            if(!empty($transaction)) {
                $wallet = Wallet::where('user_id', $transaction->user_id)->first();
                if(!empty($wallet)) {
                    if($transaction->update(['status' => 1])) {
                        $setting = Setting::first();

                        $checkTransactions = Transaction::where('user_id', $transaction->user_id)->count();
                        if($checkTransactions <= 1) {
                            /// pagar o bonus
                            $bonus = \Helper::porcentagem_xn($setting->initial_bonus, $transaction->price);
                            $wallet->increment('balance_bonus', $bonus);
                            $wallet->update(['balance_bonus_rollover' => $bonus * $setting->rollover]);
                        }else{
                            $wallet->increment('balance', $transaction->price); /// add saldo
                        }

                        $user = User::find($transaction->user_id);

                        self::saveAffiliateHistory($user); /// paga o afiliado
                        self::FinishTransaction($transaction->price, $user->id); /// finaliza a transação
                    }
                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     * @dev victormsalatiel
     */
    public function consultStatusTransactionPix(Request $request)
    {
        return self::consultStatusTransaction($request);
    }

    /**
     * Display the specified resource.
     * @dev victormsalatiel
     */
    public function withdrawalFromModal($id)
    {
        $withdrawal = Withdrawal::find($id);
        if(!empty($withdrawal)) {
            $parm = [
                'pix_key'           => $withdrawal->chave_pix,
                'pix_type'          => $withdrawal->tipo_chave,
                'amount'            => $withdrawal->amount,
                'document'          => $withdrawal->document,
                'payment_id'        => $withdrawal->id
            ];

            $resp = self::MakePayment($parm);

            if($resp) {
                $withdrawal->update(['status' => 1]);
                Notification::make()
                    ->title('Saque solicitado')
                    ->body('Saque solicitado com sucesso')
                    ->success()
                    ->send();

                return back();
            }else{
                Notification::make()
                    ->title('Erro no saque')
                    ->body('Erro ao solicitar o saque')
                    ->danger()
                    ->send();

                return back();
            }
        }
    }
}
