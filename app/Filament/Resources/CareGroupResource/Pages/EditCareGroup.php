<?php

namespace App\Filament\Resources\CareGroupResource\Pages;

use App\Filament\Resources\CareGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCareGroup extends EditRecord
{
    protected static string $resource = CareGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
