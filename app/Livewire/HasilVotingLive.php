<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PemiluEvent;
use App\Models\ProyekLomba;
use Illuminate\Support\Facades\DB;

class HasilVotingLive extends Component
{
    public $activeEvent;
    public $results = [];
    public $totalSuara = 0;
    public $topThree = []; 

    public function mount()
    {
        // Panggil updateResults() agar data langsung terisi saat komponen pertama kali dimuat
        $this->updateResults();
    }

    public function updateResults()
    {
        // 1. Ambil Event Aktif 
        $this->activeEvent = PemiluEvent::where('aktif', true)->first(); 

        if (!$this->activeEvent) {
            $this->results = [];
            $this->totalSuara = 0;
            $this->topThree = [];
            return;
        }

        $activeEventId = $this->activeEvent->id;

        // 2. Hitung Total Suara Keseluruhan
        $this->totalSuara = DB::table('log_suaras') 
            ->where('pemilu_event_id', $activeEventId)
            ->count();

        // 3. Query untuk mengambil Proyek, URL, dan hitungan suara (Diperluas untuk mengambil URL)
        $proyekLombas = ProyekLomba::select(
            'proyek_lombas.id', 
            'proyek_lombas.nama_proyek', 
            'proyek_lombas.tim_pengembang',
            'proyek_lombas.url_proyek' // <<< KOLOM BARU DIAMBIL
        )
            
            // Filter hanya proyek di event aktif
            ->where('proyek_lombas.pemilu_event_id', $activeEventId) 
            
            // LEFT JOIN untuk menghitung suara
            ->leftJoin('log_suaras', function ($join) use ($activeEventId) {
                $join->on('proyek_lombas.id', '=', 'log_suaras.proyek_lomba_id')
                     ->where('log_suaras.pemilu_event_id', '=', $activeEventId);
            })
            
            // Select data yang akan ditampilkan
            ->selectRaw('proyek_lombas.nama_proyek as nama, COUNT(log_suaras.id) as suara') 
            
            // Kelompokkan (Wajib mencakup semua kolom SELECT)
            ->groupBy('proyek_lombas.id', 'proyek_lombas.nama_proyek', 'proyek_lombas.tim_pengembang', 'proyek_lombas.url_proyek')
            
            // Urutkan berdasarkan suara terbanyak
            ->orderByDesc('suara')
            ->get();

        // 4. Susun data ke dalam format array $results
        $resultsArray = [];
        
        foreach ($proyekLombas as $proyek) {
            $suara = (int) $proyek->suara;
            
            $persentase = $this->totalSuara > 0 
                ? round(($suara / $this->totalSuara) * 100, 2)
                : 0;

            $resultsArray[] = [
                'nama' => $proyek->nama,
                'suara' => $suara,
                'persentase' => $persentase,
                'url' => $proyek->url_proyek, // <<< URL DISIMPAN DI ARRAY
            ];
        }

        $this->results = $resultsArray;
        
        // Ambil 3 Terbaik
        $this->topThree = array_slice($resultsArray, 0, 3);
    }

    public function render()
    {
        return view('livewire.hasil-voting-live');
    }
}