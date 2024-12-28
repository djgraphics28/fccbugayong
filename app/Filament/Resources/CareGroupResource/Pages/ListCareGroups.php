<?php

namespace App\Filament\Resources\CareGroupResource\Pages;

use App\Filament\Resources\CareGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCareGroups extends ListRecords
{
    protected static string $resource = CareGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
