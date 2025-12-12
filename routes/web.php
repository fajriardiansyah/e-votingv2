<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Models\PemiluEvent; // <-- Panggil model PemiluEvent
use App\Livewire\PemiluVoter;
use Carbon\Carbon; // <-- Panggil Carbon untuk manipulasi tanggal

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
Route::get('/', function () {
    // 1. Ambil event aktif dari database
    $activeEvent = PemiluEvent::where('aktif', true)->first();
    
    // 2. Jika event ditemukan, konversi tanggal ke objek Carbon 
    // agar bisa diolah dengan benar di view (format, perbandingan waktu, dll.)
    if ($activeEvent) {
         // Pastikan nama kolom 'tanggal_mulai' dan 'tanggal_selesai' sudah benar di model
         $activeEvent->tanggal_mulai = Carbon::parse($activeEvent->tanggal_mulai); 
         $activeEvent->tanggal_selesai = Carbon::parse($activeEvent->tanggal_selesai);
    }
    
    // 3. Kirim variabel $activeEvent ke view 'landing_page'
    return view('landing_page', [
        'activeEvent' => $activeEvent // <-- Variabel ini yang dibutuhkan di landing_page.blade.php
    ]);
})->name('beranda'); 

// --- 2. Rute Voting (Menggunakan Wrapper View untuk Livewire) ---
// Rute ini memanggil view 'voting.livewire_wrapper' yang di dalamnya memuat komponen Livewire
Route::get('/vote', fn() => view('voting.livewire_wrapper'))->name('voting.form');

// --- 3. Route khusus untuk menyajikan gambar proyek ---
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

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Semua route admin Anda di sini
    // Route::view('/', 'admin.dashboard')->name('admin.dashboard');
});