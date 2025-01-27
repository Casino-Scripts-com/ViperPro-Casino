<?php

namespace App\Filament\Resources\SubAffiliateResource\Pages;

use App\Filament\Resources\SubAffiliateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubAffiliate extends EditRecord
{
    protected static string $resource = SubAffiliateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
