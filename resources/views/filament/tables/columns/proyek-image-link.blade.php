{{-- resources/views/filament/tables/columns/proyek-image-link.blade.php --}}

@php
    // Ambil nilai nama file dari kolom
    $filename = $getState();
@endphp

@if($filename)
    {{-- Menggunakan route helper untuk memanggil server Laravel --}}
    <a href="{{ route('proyek.image', ['filename' => $filename]) }}" target="_blank" class="text-blue-600 hover:underline text-sm truncate">
        
        {{-- Tampilkan gambar kecil --}}
        <img 
            src="{{ route('proyek.image', ['filename' => $filename]) }}" 
            alt="Sampul" 
            class="h-10 w-10 object-cover rounded-md"
        />
        
        {{-- Tampilkan nama file sebagai fallback --}}
        <span class="block text-xs text-gray-500 mt-1">{{ Str::limit($filename, 15) }}</span>
    </a>
@else
    Tidak Ada Foto
@endif