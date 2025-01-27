<?php

namespace App\Traits\Affiliates;

use App\Models\AffiliateHistory;
use App\Models\User;
use App\Models\Wallet;

trait EarningTrait
{
    /**
     * @param User $user // ID do afiliado
     * @return void
     */
    public static function affiliateRevshare(User $user)
    {
        $affiliateHistories = AffiliateHistory::where('inviter', $user->id)->where('commission_type', 'revshare')->where('status', 0)->get();
        if(count($affiliateHistories) > 0) {
            foreach ($affiliateHistories as $affiliateHistory) {

                /// o valor de perda é maior que o valor depositado
                if($affiliateHistory->losses_amount >= $affiliateHistory->deposited_amount) {

                    /// pega a porcentagem do ganho
                    $gains = \Helper::porcentagem_xn($affiliateHistory->commission, $affiliateHistory->losses_amount);
                    $wallet = Wallet::where('user_id', $user->id)->first();
                    $wallet->increment('refer_rewards', $gains);
                }
            }
        }
    }

    /**
     * @param User $user // ID do afiliado
     * @return void
     */
    public static function affiliateCpa(User $user)
    {
        $affiliateHistories = AffiliateHistory::where('inviter', $user->id)->where('commission_type', 'cpa')->where('status', 0)->get();
        if(count($affiliateHistories) > 0) {
            foreach ($affiliateHistories as $affiliateHistory) {
                /// o valor de perda é maior que o valor depositado
                if($affiliateHistory->losses_amount >= $affiliateHistory->deposited_amount) {

                    /// pega a porcentagem do ganho
                    $wallet = Wallet::where('user_id', $user->id)->first();
                    $wallet->increment('refer_rewards', $user->affiliate_cpa);
                }
            }
        }
    }
}
