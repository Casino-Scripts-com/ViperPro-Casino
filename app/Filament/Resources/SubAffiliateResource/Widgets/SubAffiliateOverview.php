<?php

namespace App\Filament\Resources\SubAffiliateResource\Widgets;

use App\Models\AffiliateHistory;
use Filament\Notifications\Notification;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Str;

class SubAffiliateOverview extends BaseWidget
{
    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        $rendaAff = AffiliateHistory::where('inviter', auth()->id())->sum('commission_paid');

        return [
            Stat::make('Renda', \Helper::amountFormatDecimal($rendaAff)),
            Stat::make('Link de Convite', 'convite')
                ->view('filament.components.convite'),
        ];
    }

    public function copyReferCode()
    {

    }
}
