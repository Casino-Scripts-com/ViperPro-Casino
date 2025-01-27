<?php

namespace App\Filament\Widgets;

use App\Models\AffiliateHistory;
use App\Models\Order;
use App\Models\User;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Helpers\Core as Helper;

class StatsUserDetailOverview extends BaseWidget
{

    public User $record;

    public function mount($record)
    {
       $this->record = $record;
    }

    /**
     * @return array|Stat[]
     */
    protected function getStats(): array
    {
        $totalGanhos = Order::where('user_id', $this->record->id)->where('type', 'win')->sum('amount');
        $totalPerdas = Order::where('user_id', $this->record->id)->where('type', 'loss')->sum('amount');
        $totalAfiliados = AffiliateHistory::where('inviter', $this->record->id)->sum('commission_paid');

        return [
            Stat::make('Total de Ganhos', Helper::amountFormatDecimal(Helper::formatNumber($totalGanhos)))
                ->description('Total de Ganhos na plataforma')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total de Perdas', Helper::amountFormatDecimal(Helper::formatNumber($totalPerdas)))
                ->description('Total de Perdas na plataforma')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Ganhos como Afiliado', Helper::amountFormatDecimal(Helper::formatNumber($totalAfiliados)))
                ->description('Total de Ganhos como afiliado')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}
