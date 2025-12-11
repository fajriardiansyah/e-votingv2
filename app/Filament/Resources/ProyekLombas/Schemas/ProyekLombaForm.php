<?php

namespace App\Filament\Resources\ProyekLombas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

class ProyekLombaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('pemilu_event_id')
                    ->relationship('pemiluEvent', 'nama')
                    ->required()
                    ->label('Event Terkait'),
                TextInput::make('nama_proyek')->required()->label('Nama Proyek / Sistem'),
                TextInput::make('tim_pengembang')->label('Tim Pengembang'),
                FileUpload::make('foto_sampul')
                    ->label('Foto Sampul Proyek')
                    ->directory('proyek-lomba') // Menyimpan di 'storage/app/public/images/proyeks'
                    ->image() // Hanya mengizinkan file gambar
                    ->imageEditor() // Mengaktifkan editor gambar (opsional, tapi bagus)
                    ->maxSize(2048) // Maksimal 2MB
                    ->columnSpanFull() // Mengambil lebar penuh
                    ->nullable(),
                Textarea::make('deskripsi')->label('Deskripsi Singkat Proyek'),
                TextInput::make('url_proyek') // <<< Tambahkan ini
                ->label('URL Proyek (Domain Aktif)')
                ->placeholder('Contoh: https://luxelabs.com')
                ->url() // Validasi input harus berupa URL
                ->columnSpanFull(),
            ]);
    }
}
