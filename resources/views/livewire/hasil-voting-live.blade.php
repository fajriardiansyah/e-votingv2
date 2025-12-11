{{-- resources/views/livewire/hasil-voting-live.blade.php --}}
<div wire:poll.5s="updateResults" class="w-full">
    
    @if ($activeEvent)
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- === KOLOM KIRI: RINGKASAN & RANKING 3 TERBAIK (1/3 Lebar) === --}}
            <div class="col-span-1 space-y-6">
                
                {{-- KARTU 1: TOTAL SUARA MASUK --}}
                <div class="bg-gray-50 p-6 rounded-xl shadow-md border-t-4 border-blue-600">
                    <p class="text-sm font-medium text-gray-500">Total Suara Masuk</p>
                    <p class="text-4xl font-bold text-blue-600 mt-1">{{ number_format($totalSuara) }}</p>
                    <p class="text-xs text-gray-400 mt-2">Update terakhir: {{ now()->format('H:i:s') }} WIB</p>
                </div>

                {{-- KARTU 2: RANKING 3 TERBAIK (Nama Proyek Berupa Link) --}}
                <div class="bg-gray-50 p-6 rounded-xl shadow-md border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">🏆 Ranking 3 Terbaik</h3>
                    
                    @forelse ($topThree as $rank => $result)
                        <div class="flex justify-between items-center py-2 {{ $loop->last ? '' : 'border-b border-gray-100' }}">
                            
                            {{-- RANKING & NAMA --}}
                            <div class="flex items-center space-x-2">
                                <span class="text-xl font-extrabold 
                                    {{ ($rank + 1) == 1 ? 'text-yellow-500' : 
                                       (($rank + 1) == 2 ? 'text-gray-400' : 'text-amber-700') }}">
                                    #{{ $rank + 1 }}
                                </span>
                                {{-- Link ke Proyek --}}
                                @if ($result['url'])
                                    <a href="{{ $result['url'] }}" target="_blank" class="text-sm font-semibold text-blue-600 hover:text-blue-700 truncate">
                                        {{ $result['nama'] }}
                                    </a>
                                @else
                                    <span class="text-sm font-semibold text-gray-700 truncate">{{ $result['nama'] }}</span>
                                @endif
                                {{-- End Link --}}
                            </div>
                            
                            {{-- PERSENTASE SUARA --}}
                            <span class="text-sm font-bold text-green-600">
                                {{ $result['persentase'] }}%
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada suara yang masuk.</p>
                    @endforelse
                </div>
                {{-- Akhir KARTU 2 --}}
            </div>

            {{-- === KOLOM KANAN: DAFTAR PROGRES BAR (2/3 Lebar) === --}}
            <div class="col-span-1 md:col-span-2 space-y-4">
                <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Progres Suara Proyek</h3>

                @if (count($results) > 0)
                    @foreach ($results as $result)
                        <div class="p-4 bg-white rounded-lg shadow-sm border border-gray-100">
                            
                            {{-- Nama Proyek dan Persentase/Suara --}}
                            <div class="flex justify-between items-center text-base font-medium text-gray-800">
                                
                                {{-- Link ke Proyek (dengan ikon link) --}}
                                @if ($result['url'])
                                    <a href="{{ $result['url'] }}" target="_blank" class="text-base font-semibold text-blue-600 hover:text-blue-700 flex items-center space-x-2">
                                        <span>{{ $result['nama'] }}</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                @else
                                    <span>{{ $result['nama'] }}</span>
                                @endif
                                {{-- End Link --}}
                                
                                <span class="text-sm font-bold text-blue-600">
                                    {{ $result['persentase'] }}% ({{ number_format($result['suara']) }})
                                </span>
                            </div>
                            
                            {{-- Progress Bar --}}
                            <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                <div 
                                    class="h-2 rounded-full transition-all duration-700 ease-out {{ $loop->first ? 'bg-green-500' : 'bg-blue-500' }}" 
                                    style="width: {{ $result['persentase'] }}%"
                                ></div>
                            </div>
                            
                            {{-- Indikator Status --}}
                            <div class="mt-1 text-xs text-right text-gray-500">
                                @if ($result['suara'] > 0)
                                    <span class="text-green-500">✅ Pilihan</span>
                                @else
                                    <span class="text-gray-400">🕒 Belum Ada Vote</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                @else
                    <div class="text-center py-6 text-gray-500 bg-gray-100 rounded-lg">
                        Belum ada proyek atau suara masuk untuk event ini.
                    </div>
                @endif
            </div>
        </div>
        
    @else
        <div class="text-center py-12 bg-red-50 border-2 border-red-200 rounded-xl text-red-700">
            <p class="text-lg font-semibold">🛑 Tidak Ada Event Aktif Saat Ini.</p>
        </div>
    @endif
    
</div>