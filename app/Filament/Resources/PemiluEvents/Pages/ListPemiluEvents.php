<?php

namespace App\Filament\Resources\PemiluEvents\Pages;

use App\Filament\Resources\PemiluEvents\PemiluEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPemiluEvents extends ListRecords
{
    protected static string $resource = PemiluEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
