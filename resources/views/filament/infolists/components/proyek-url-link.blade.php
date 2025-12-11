{{-- resources/views/filament/infolists/components/proyek-url-link.blade.php --}}

@php
    // $getState() mengambil nilai dari kolom 'url_proyek'
    $url = $getState();
    // Mendapatkan hostname untuk tampilan yang lebih rapi
    $hostname = parse_url($url, PHP_URL_HOST) ?? $url;
    // Jika hostname kosong (misal: hanya diberi "/"), tampilkan URL lengkap
    if ($hostname === '') {
        $hostname = $url;
    }
@endphp

<div class="fi-in-entry-wrapper">
    @if ($url)
        <a 
            href="{{ $url }}" 
            target="_blank" 
            class="fi-in-link flex items-center space-x-2 p-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-sm font-semibold text-blue-600 transition duration-150 border border-blue-200"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
            <span>Buka Website Proyek: **{{ $hostname }}**</span>
        </a>
    @else
        <span class="text-sm text-gray-500 p-2 border rounded-lg bg-gray-50">URL Proyek Belum Ditetapkan</span>
    @endif
</div>