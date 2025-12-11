<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PemiluVoter;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- 1. Rute Beranda (Landing Page) ---
Route::get('/', fn() => view('landing_page'))->name('beranda'); 

// --- 2. Rute Voting (Menggunakan Wrapper View untuk Livewire) ---
// Rute ini memanggil view 'voting.livewire_wrapper' yang di dalamnya memuat komponen Livewire
Route::get('/vote', fn() => view('voting.livewire_wrapper'))->name('voting.form');

// Route khusus untuk menyajikan gambar proyek yang disimpan di disk 'local'
// Path: /get-proyek-image/nama_file.jpeg
Route::get('/get-proyek-image/{filename}', function ($filename) {
    // PASTI BEDA: Sesuaikan dengan folder tempat Filament menyimpan file (storage/app/proyek-lomba/)
    $path = 'proyek-lomba/' . $filename; 

    // Menggunakan disk 'local' karena Anda menghilangkan ->disk('public')
    if (Storage::disk('local')->exists($path)) {
        return response()->download(Storage::disk('local')->path($path));
    }

    // Jika file tidak ditemukan, kembalikan 404
    abort(404);

})->name('proyek.image');