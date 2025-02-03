<?php

namespace App\Filament\Resources\YouthCampResource\Pages;

use App\Filament\Resources\YouthCampResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYouthCamp extends EditRecord
{
    protected static string $resource = YouthCampResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
