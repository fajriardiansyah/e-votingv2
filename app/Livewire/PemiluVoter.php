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
        $this->validate($this->getRules()); 
        
        if (!$this->activeEvent) {
            session()->flash('error', 'Event sudah berakhir atau tidak ditemukan.');
            return;
        }

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
            $this->status = 'success'; 

            // TIDAK ADA DELAYED REDIRECT DI SINI
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat merekam suara Anda. Silakan coba lagi.');
        }
    }

    public function render()
    {
        return view('livewire.pemilu-voter');
    }
}