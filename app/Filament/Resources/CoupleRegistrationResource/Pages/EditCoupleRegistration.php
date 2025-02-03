<?php

namespace App\Filament\Resources\CoupleRegistrationResource\Pages;

use App\Filament\Resources\CoupleRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoupleRegistration extends EditRecord
{
    protected static string $resource = CoupleRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
