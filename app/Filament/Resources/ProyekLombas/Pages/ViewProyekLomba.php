<?php

namespace App\Filament\Resources\ProyekLombas\Pages;

use App\Filament\Resources\ProyekLombas\ProyekLombaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProyekLomba extends ViewRecord
{
    protected static string $resource = ProyekLombaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
