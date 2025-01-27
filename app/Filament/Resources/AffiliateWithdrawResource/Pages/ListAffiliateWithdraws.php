<?php

namespace App\Filament\Resources\AffiliateWithdrawResource\Pages;

use App\Filament\Resources\AffiliateWithdrawResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAffiliateWithdraws extends ListRecords
{
    protected static string $resource = AffiliateWithdrawResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\Action::make('request_withdraw')
//                ->label('Solicitar saque')
//                ->action(function () {
//                   dd("1233");
//                })

        ];
    }
}
