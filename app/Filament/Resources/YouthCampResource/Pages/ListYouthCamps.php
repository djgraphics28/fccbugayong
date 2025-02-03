<?php

namespace App\Filament\Resources\YouthCampResource\Pages;

use App\Filament\Resources\YouthCampResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYouthCamps extends ListRecords
{
    protected static string $resource = YouthCampResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
