<?php
// app/Livewire/PemiluVoter.php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PemiluEvent;
use App\Models\LogSuara;
use App\Models\ProyekLomba; 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// === START: IMPORTS BARU UNTUK KEAMANAN & TIMING ===
use Carbon\Carbon; 
use Illuminate\Support\Facades\RateLimiter; 
// === END: IMPORTS BARU ===

class PemiluVoter extends Component
{
    public $activeEvent;
    public $proyekLombas;
    public $status = 'loading'; 
    
    public $identitas_voter = '';
    public $proyek_id_yang_dipilih = null;

    public $tipe_voter = null; 
    public $kategori_internal = null; 
    public $jabatan_eksternal = null;
    public $nama_perusahaan = null;

    // METHOD PERBAIKAN: Akses harus PUBLIC untuk validasi Livewire
    public function getRules()
    {
        $rules = [
            'proyek_id_yang_dipilih' => ['required', 'exists:proyek_lombas,id'],
            'tipe_voter' => ['required', Rule::in(['Internal', 'Eksternal'])],
        ];

        if ($this->tipe_voter === 'Internal') {
            $rules['kategori_internal'] = ['required', Rule::in(['Mahasiswa', 'Dosen', 'Staff'])];
            $rules['identitas_voter'] = ['required', 'string', 'max:255'];
            
            $rules['jabatan_eksternal'] = ['nullable'];
            $rules['nama_perusahaan'] = ['nullable'];

        } elseif ($this->tipe_voter === 'Eksternal') {
            $rules['identitas_voter'] = ['required', 'string', 'max:255'];
            $rules['jabatan_eksternal'] = ['required', 'string', 'max:255'];
            $rules['nama_perusahaan'] = ['required', 'string', 'max:255'];
            
            $rules['kategori_internal'] = ['nullable'];
        }

        return $rules;
    }
    
    public function mount(Request $request)
    {
        $this->activeEvent = PemiluEvent::where('aktif', true)->first();
        
        if (!$this->activeEvent) {
            $this->status = 'no_event';
            return;
        }

        // === START: LOGIKA BATASAN WAKTU DI MOUNT (Tampilan Awal) ===
        $now = Carbon::now();

        if ($this->activeEvent->tanggal_mulai && $now->lt($this->activeEvent->tanggal_mulai)) {
            $this->status = 'event_soon'; // Status baru: Belum Mulai
            return;
        }
        if ($this->activeEvent->tanggal_selesai && $now->gt($this->activeEvent->tanggal_selesai)) {
            $this->status = 'event_ended'; // Status baru: Sudah Selesai
            return;
        }
        // === END: LOGIKA BATASAN WAKTU DI MOUNT ===

        $voterIp = $request->ip();
        $voterDevice = $request->header('User-Agent');

        $alreadyVoted = LogSuara::where('pemilu_event_id', $this->activeEvent->id)
                                 ->where('ip_pemilih', $voterIp)
                                 ->where('perangkat_pemilih', $voterDevice)
                                 ->exists();

        if ($alreadyVoted) {
             $this->status = 'already_voted';
             return;
        }

        $this->proyekLombas = $this->activeEvent->proyekLombas;
        $this->status = 'form';
    }

    public function prosesSuara(Request $request)
    {
        // 1. Cek Event Aktif (Pengecekan di awal untuk keamanan)
        if (!$this->activeEvent) {
            session()->flash('error', 'Event sudah berakhir atau tidak ditemukan.');
            return;
        }
        
        // === START: RATE LIMITING (5x per 1 menit) ===
        $rateLimitKey = $request->ip() . '|pemiluvoter|' . $this->activeEvent->id;

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5, 60)) { // Maks 5x per 60 detik
            $seconds = RateLimiter::availableIn($rateLimitKey);
            session()->flash('error', "Anda mencoba voting terlalu sering. Harap tunggu {$seconds} detik.");
            return;
        }
        
        RateLimiter::hit($rateLimitKey); // Mencatat satu attempt
        // === END: RATE LIMITING ===

        // === START: LOGIKA BATASAN WAKTU VOTING (Server Side Validation) ===
        $now = Carbon::now();

        // Cek Waktu Mulai
        if ($this->activeEvent->tanggal_mulai && $now->lt($this->activeEvent->tanggal_mulai)) {
            $msg = 'Pemilihan Belum Dimulai. Harap tunggu hingga ' . $this->activeEvent->tanggal_mulai->format('d M Y H:i');
            session()->flash('error', $msg);
            RateLimiter::clear($rateLimitKey); // Bersihkan limit
            return;
        }

        // Cek Waktu Selesai
        if ($this->activeEvent->tanggal_selesai && $now->gt($this->activeEvent->tanggal_selesai)) {
            $msg = 'Pemilihan Telah Berakhir pada ' . $this->activeEvent->tanggal_selesai->format('d M Y H:i');
            session()->flash('error', $msg);
            RateLimiter::clear($rateLimitKey); // Bersihkan limit
            return;
        }
        // === END: LOGIKA BATASAN WAKTU ===
        
        // Lanjutkan Validasi Input Livewire
        $this->validate($this->getRules()); 
        
        // Cek Duplikasi Suara (Logika yang sudah ada)
        $voterIp = $request->ip();
        $voterDevice = $request->header('User-Agent');
        
        $alreadyVoted = LogSuara::where('pemilu_event_id', $this->activeEvent->id)
                                 ->where('ip_pemilih', $voterIp)
                                 ->where('perangkat_pemilih', $voterDevice)
                                 ->exists();

        if ($alreadyVoted) {
            $this->status = 'already_voted';
            RateLimiter::clear($rateLimitKey); // Bersihkan limit
            return;
        }

        // --- Penyimpanan DB ---
        DB::beginTransaction();
        try {
            LogSuara::create([
                'pemilu_event_id' => $this->activeEvent->id,
                'proyek_lomba_id' => $this->proyek_id_yang_dipilih,
                
                'tipe_voter' => $this->tipe_voter,
                'identitas_voter' => $this->identitas_voter,
                
                'kategori_internal' => $this->tipe_voter === 'Internal' ? $this->kategori_internal : null,
                'jabatan_eksternal' => $this->tipe_voter === 'Eksternal' ? $this->jabatan_eksternal : null,
                'nama_perusahaan' => $this->tipe_voter === 'Eksternal' ? $this->nama_perusahaan : null,

                'ip_pemilih' => $voterIp,
                'perangkat_pemilih' => $voterDevice,
            ]);

            DB::commit();
            RateLimiter::clear($rateLimitKey); // Bersihkan limit setelah vote sukses
            $this->status = 'success'; 
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat merekam suara Anda. Silakan coba lagi.');
        }
    }

    public function render()
    {
        // Perluas logika render agar bisa menampilkan status baru (event_soon, event_ended)
        return view('livewire.pemilu-voter', [
            'proyekLombas' => $this->proyekLombas,
            'activeEvent' => $this->activeEvent,
            'status' => $this->status
        ]);
    }
}