<?php

namespace App\Filament\Resources\PemiluEvents;

use App\Filament\Resources\PemiluEvents\Pages\CreatePemiluEvent;
use App\Filament\Resources\PemiluEvents\Pages\EditPemiluEvent;
use App\Filament\Resources\PemiluEvents\Pages\ListPemiluEvents;
use App\Filament\Resources\PemiluEvents\Pages\ViewPemiluEvent;
use App\Filament\Resources\PemiluEvents\Schemas\PemiluEventForm;
use App\Filament\Resources\PemiluEvents\Schemas\PemiluEventInfolist;
use App\Filament\Resources\PemiluEvents\Tables\PemiluEventsTable;
use App\Models\PemiluEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PemiluEventResource extends Resource
{
    protected static ?string $model = PemiluEvent::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    public static function getModelLabel(): string { return 'Event Pemilihan'; }
    public static function getPluralModelLabel(): string { return 'Daftar Event Pemilihan'; }

    public static function form(Schema $schema): Schema
    {
        return PemiluEventForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PemiluEventInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PemiluEventsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPemiluEvents::route('/'),
            'create' => CreatePemiluEvent::route('/create'),
            'view' => ViewPemiluEvent::route('/{record}'),
            'edit' => EditPemiluEvent::route('/{record}/edit'),
        ];
    }
}
