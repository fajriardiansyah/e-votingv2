<?php

namespace App\Filament\Resources\LogSuaras\Pages;

use App\Filament\Resources\LogSuaras\LogSuaraResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLogSuara extends EditRecord
{
    protected static string $resource = LogSuaraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
