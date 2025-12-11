<?php

namespace App\Filament\Resources\LogSuaras\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class LogSuarasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('identitas_voter')->label('Identitas Voter')->searchable()->sortable(),
                TextColumn::make('proyekLomba.nama_proyek')->label('Proyek Dipilih')->sortable()->searchable(),
                TextColumn::make('pemiluEvent.nama')->label('Event')->sortable(),
                TextColumn::make('ip_pemilih')->label('IP Pemilih'),
                TextColumn::make('perangkat_pemilih')->label('Device')->limit(40),
                TextColumn::make('created_at')->dateTime('d M Y H:i:s')->label('Waktu Suara')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
