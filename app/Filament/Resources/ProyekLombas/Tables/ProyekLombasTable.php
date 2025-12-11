<?php

namespace App\Filament\Resources\ProyekLombas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class ProyekLombasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_proyek')->searchable()->sortable()->label('Nama Proyek'),
                TextColumn::make('pemiluEvent.nama')->label('Event'),
                TextColumn::make('tim_pengembang')->label('Tim'),
                ImageColumn::make('foto_sampul')
                    ->label('Sampul (Lokal)')
                    // GUNAKAN 'view' UNTUK MENGRENDER BLADE CUSTOM
                    ->view('filament.tables.columns.proyek-image-link') // <<< Ini yang benar
                    ->limit(20) 
                    ->searchable(),
                TextColumn::make('url_proyek')->label('URL Proyek')->url(fn($record) => $record->url_proyek)->openUrlInNewTab()
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
