<?php

namespace App\Filament\Widgets;

use App\Models\GGRGamesFiver;
use App\Models\GgrGamesWorldSlot;
use App\Traits\Providers\FiversTrait;
use App\Traits\Providers\WorldSlotTrait;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GGROverview extends BaseWidget
{
    use WorldSlotTrait;

    protected function getStats(): array
    {
        $balance = self::getWorldSlotBalance();
        $creditoGastos = GgrGamesWorldSlot::sum('balance_bet');
        $totalPartidas = GgrGamesWorldSlot::count();

        return [
            Stat::make('Créditos Fivers', ($balance ?? '0'))
                ->description('Saldo atual na World Slot')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7,3,4,5,6,3,5,3]),
            Stat::make('Créditos Gastos Fivers', \Helper::amountFormatDecimal($creditoGastos))
                ->description('Créditos gastos por usuários')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7,3,4,5,6,3,5,3]),
            Stat::make('Total de Partidas Fivers', $totalPartidas)
                ->description('Total de Partidas World Slot')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7,3,4,5,6,3,5,3]),
        ];
    }

    /**
     * @return bool
     */
    public static function canView(): bool
    {
        return auth()->user()->hasRole('admin');
    }
}
