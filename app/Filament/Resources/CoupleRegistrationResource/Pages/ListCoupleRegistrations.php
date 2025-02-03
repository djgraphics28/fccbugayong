<?php

namespace App\Filament\Resources\CoupleRegistrationResource\Pages;

use App\Filament\Resources\CoupleRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoupleRegistrations extends ListRecords
{
    protected static string $resource = CoupleRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
