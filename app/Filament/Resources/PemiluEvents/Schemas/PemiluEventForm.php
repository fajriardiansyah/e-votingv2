<?php

namespace App\Filament\Resources\PemiluEvents\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;

class PemiluEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')->required()->maxLength(255)->label('Nama Event'),
                DateTimePicker::make('tanggal_mulai')->required()->label('Tanggal Mulai'),
                DateTimePicker::make('tanggal_selesai')->required()->label('Tanggal Selesai'),
                Toggle::make('aktif')->required()->label('Event Aktif Saat Ini')
                    ->helperText('Hanya satu event yang boleh aktif pada satu waktu.'),
            ]);
    }
}
