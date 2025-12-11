<?php
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\PemiluEvent;
use App\Models\LogSuara;
use Illuminate\Support\Facades\DB;

class HasilPemiluChart extends ChartWidget
{
    // Menggunakan method untuk mendefinisikan heading
    public function getHeading(): string
    {
        return 'Hasil Pemilihan Real-Time';
    }
    
    protected function getMaxHeight(): ?string
    {
        return '300px';
    }

    protected function getType(): string
    {
        return 'bar'; // Menggunakan Bar Chart
    }

    protected function getData(): array
    {
        // 1. Ambil Event yang sedang aktif
        $activeEvent = PemiluEvent::where('aktif', true)->first();
        
        // Jika tidak ada event aktif, tampilkan data kosong
        if (!$activeEvent) {
            return [
                'datasets' => [[ 'label' => 'Total Suara Masuk', 'data' => [0], 'backgroundColor' => '#9CA3AF' ]],
                'labels' => ['Tidak ada Event Aktif'],
            ];
        }

        // 2. Hitung jumlah suara per Proyek Lomba pada event aktif
        $results = LogSuara::select('proyek_lomba_id', DB::raw('count(*) as total_suara'))
            ->where('pemilu_event_id', $activeEvent->id)
            ->groupBy('proyek_lomba_id')
            ->with('proyekLomba') 
            ->get();

        // 3. Format data untuk Chart
        $labels = $results->map(fn ($item) => $item->proyekLomba->nama_proyek)->toArray();
        $data = $results->map(fn ($item) => $item->total_suara)->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Total Suara Masuk',
                    'data' => $data,
                    'backgroundColor' => '#2563EB',
                ],
            ],
            'labels' => $labels,
        ];
    }
}