<?php

namespace App\Filament\Widgets;

use App\Models\AffiliateHistory;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class AffiliateChart extends ChartWidget
{
    protected static ?string $heading = 'Estatisticas de Conversão';
    protected int | string | array $columnSpan = 'full';

    /**
     * @return array|mixed[]
     */
    protected function getData(): array
    {
        $data = $this->getComissionPerMonth();

        return [
            'datasets' => [
                [
                    'label' => 'Estatisticas de Conversão',
                    'data' => $data['comissionsPerMonth'],
                ],
            ],
            'labels' => $data['months'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    /**
     *
     * @dev victormsalatiel
     * @return array
     */
    private function getComissionPerMonth(): array
    {
        $now = Carbon::now();
        $comissionsPerMonth = [];

        $months = collect(range(1, 12))->map(function($month) use ($now, $comissionsPerMonth ) {
            $sum = AffiliateHistory::where('inviter', auth()->id())->where('commission_type', 'revshare')
                ->whereMonth('created_at', Carbon::parse($now->month($month)->format('Y-m')))
                ->sum('commission_paid');

            $comissionsPerMonth[] = $sum;
            return $now->month($month)->format('M');
        })->toArray();

        return [
            'comissionsPerMonth' => $comissionsPerMonth,
            'months' => $months
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
