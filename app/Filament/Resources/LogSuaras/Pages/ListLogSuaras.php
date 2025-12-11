<?php

namespace App\Filament\Resources\LogSuaras\Pages;

use App\Filament\Resources\LogSuaras\LogSuaraResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLogSuaras extends ListRecords
{
    protected static string $resource = LogSuaraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
