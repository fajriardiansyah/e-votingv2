<?php

namespace App\Filament\Resources\PemiluEvents\Pages;

use App\Filament\Resources\PemiluEvents\PemiluEventResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPemiluEvent extends ViewRecord
{
    protected static string $resource = PemiluEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
