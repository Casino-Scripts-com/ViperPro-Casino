<?php

namespace App\Livewire;

use App\Models\AffiliateHistory;
use App\Models\User;
use App\Models\Wallet;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminWidgets extends BaseWidget
{
    protected static ?int $navigationSort = -2;

    /**
     * @return array|Stat[]
     */
    protected function getCards(): array
    {
        if(auth()->check()) {
            $inviterId = auth()->user()->id;
            $usersIds = User::where('inviter', $inviterId)->get()->pluck('id');

            if(!empty($usersIds)) {
                $comissaoRevshare   = AffiliateHistory::whereIn('user_id', $usersIds)->where('commission_type', 'revshare')->sum('commission_paid');
                $comissaoCPAs       = AffiliateHistory::whereIn('user_id', $usersIds)->where('commission_type', 'cpa')->sum('commission_paid');
                $lossesRev          = AffiliateHistory::whereIn('user_id', $usersIds)->where('commission_type', 'revshare')->sum('losses_amount');
            }
        }else{
            $comissaoRevshare   = 0;
            $comissaoCPAs       = 0;
            $lossesRev       = 0;
        }

        return [
            Stat::make('Comissão CPA', \Helper::amountFormatDecimal($comissaoCPAs))
                ->description('Comissão Cpa')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Comissão Revshare', \Helper::amountFormatDecimal($comissaoRevshare))
                ->description('Comissão revshare')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Perdas', \Helper::amountFormatDecimal($lossesRev))
                ->description('Perdas dos indicados')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
        ];
    }

    /**
     * @return bool
     */
    public static function canView(): bool
    {
        return auth()->user()->hasRole('afiliado');
    }
}
