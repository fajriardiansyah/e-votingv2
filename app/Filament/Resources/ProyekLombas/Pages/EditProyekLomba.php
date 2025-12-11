<?php

namespace App\Filament\Resources\ProyekLombas\Pages;

use App\Filament\Resources\ProyekLombas\ProyekLombaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProyekLomba extends EditRecord
{
    protected static string $resource = ProyekLombaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
