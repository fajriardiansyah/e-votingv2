<?php

namespace App\Filament\Resources\ProyekLombas\Pages;

use App\Filament\Resources\ProyekLombas\ProyekLombaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProyekLombas extends ListRecords
{
    protected static string $resource = ProyekLombaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
