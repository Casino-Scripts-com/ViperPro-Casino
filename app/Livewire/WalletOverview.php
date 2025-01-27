<?php

namespace App\Livewire;

use App\Models\Deposit;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class WalletOverview extends BaseWidget
{
    protected static ?int $sort = -2;
    use InteractsWithPageFilters;

    /**
     * @return array|Stat[]
     */
    protected function getStats(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        $setting = \Helper::getSetting();
        $dataAtual = Carbon::now();
        $depositQuery = Deposit::query();
        $withdrawalQuery = Withdrawal::query();

        if(empty($startDate) && empty($endDate)) {
            $depositQuery->whereMonth('created_at', Carbon::now()->month);
        }else{
            $depositQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Executa a consulta para obter a soma dos depósitos para o mês atual
        $sumDepositMonth = $depositQuery
            ->where('status', 1)
            ->sum('amount');

        $withdrawalQuery->where('status', 1);

        if(empty($startDate) && empty($endDate)) {
            $withdrawalQuery->whereMonth('created_at', Carbon::now()->month);
        }else{
            $withdrawalQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        $sumWithdrawalMonth = $withdrawalQuery->sum('amount');
        $revshare = \Helper::porcentagem_xn($setting->revshare_percentage, $sumDepositMonth);

        return [
            Stat::make('Depositos', \Helper::amountFormatDecimal($sumDepositMonth))
                ->description('Total de Depositos')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Saques', \Helper::amountFormatDecimal($sumWithdrawalMonth))
                ->description('Total de saques')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),
            Stat::make('Revshare', \Helper::amountFormatDecimal($revshare))
                ->description('Ganhos da Plataforma')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
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
