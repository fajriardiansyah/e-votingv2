<?php

namespace App\Filament\Resources\ProyekLombas;

use App\Filament\Resources\ProyekLombas\Pages\CreateProyekLomba;
use App\Filament\Resources\ProyekLombas\Pages\EditProyekLomba;
use App\Filament\Resources\ProyekLombas\Pages\ListProyekLombas;
use App\Filament\Resources\ProyekLombas\Pages\ViewProyekLomba;
use App\Filament\Resources\ProyekLombas\Schemas\ProyekLombaForm;
use App\Filament\Resources\ProyekLombas\Schemas\ProyekLombaInfolist;
use App\Filament\Resources\ProyekLombas\Tables\ProyekLombasTable;
use App\Models\ProyekLomba;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProyekLombaResource extends Resource
{
    protected static ?string $model = ProyekLomba::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function getModelLabel(): string { return 'Proyek Lomba'; }
    public static function getPluralModelLabel(): string { return 'Daftar Proyek Lomba'; }

    public static function form(Schema $schema): Schema
    {
        return ProyekLombaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProyekLombaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProyekLombasTable::configure($table);
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
            'index' => ListProyekLombas::route('/'),
            'create' => CreateProyekLomba::route('/create'),
            'view' => ViewProyekLomba::route('/{record}'),
            'edit' => EditProyekLomba::route('/{record}/edit'),
        ];
    }
}
