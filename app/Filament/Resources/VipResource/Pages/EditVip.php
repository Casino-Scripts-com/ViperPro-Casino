<?php

namespace App\Filament\Resources\VipResource\Pages;

use App\Filament\Resources\VipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVip extends EditRecord
{
    protected static string $resource = VipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
