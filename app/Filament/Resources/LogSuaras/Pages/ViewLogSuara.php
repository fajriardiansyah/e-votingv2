<?php

namespace App\Filament\Resources\LogSuaras\Pages;

use App\Filament\Resources\LogSuaras\LogSuaraResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLogSuara extends ViewRecord
{
    protected static string $resource = LogSuaraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
