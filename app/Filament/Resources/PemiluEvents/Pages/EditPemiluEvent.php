<?php

namespace App\Filament\Resources\PemiluEvents\Pages;

use App\Filament\Resources\PemiluEvents\PemiluEventResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPemiluEvent extends EditRecord
{
    protected static string $resource = PemiluEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
