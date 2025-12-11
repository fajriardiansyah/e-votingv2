<?php

namespace App\Filament\Resources\PemiluEvents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class PemiluEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable()->sortable()->label('Nama Event'),
                TextColumn::make('tanggal_mulai')->dateTime('d M Y H:i')->label('Mulai'),
                TextColumn::make('tanggal_selesai')->dateTime('d M Y H:i')->label('Selesai'),
                IconColumn::make('aktif')->boolean()->label('Status Aktif'),
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
