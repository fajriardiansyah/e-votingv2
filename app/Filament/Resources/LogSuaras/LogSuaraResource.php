<?php

namespace App\Filament\Resources\LogSuaras;

use App\Filament\Resources\LogSuaras\Pages\CreateLogSuara;
use App\Filament\Resources\LogSuaras\Pages\EditLogSuara;
use App\Filament\Resources\LogSuaras\Pages\ListLogSuaras;
use App\Filament\Resources\LogSuaras\Pages\ViewLogSuara;
use App\Filament\Resources\LogSuaras\Schemas\LogSuaraForm;
use App\Filament\Resources\LogSuaras\Schemas\LogSuaraInfolist;
use App\Filament\Resources\LogSuaras\Tables\LogSuarasTable;
use App\Models\LogSuara;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LogSuaraResource extends Resource
{
    protected static ?string $model = LogSuara::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-pie';
    protected static string|UnitEnum|null $navigationGroup = 'Laporan';

    public static function getModelLabel(): string { return 'Log Suara'; }
    public static function getPluralModelLabel(): string { return 'Laporan Log Suara'; }

    public static function form(Schema $schema): Schema
    {
        return LogSuaraForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LogSuaraInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LogSuarasTable::configure($table);
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
            'index' => ListLogSuaras::route('/'),
        ];
    }
}
