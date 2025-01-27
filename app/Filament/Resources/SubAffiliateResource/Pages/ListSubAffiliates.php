<?php

namespace App\Filament\Resources\SubAffiliateResource\Pages;

use App\Filament\Resources\SubAffiliateResource;
use App\Filament\Resources\SubAffiliateResource\Widgets\SubAffiliateOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubAffiliates extends ListRecords
{
    protected static string $resource = SubAffiliateResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    /**
     * @return string[]
     */
    protected function getHeaderWidgets(): array
    {
        return [
            SubAffiliateOverview::class
        ];
    }
}
