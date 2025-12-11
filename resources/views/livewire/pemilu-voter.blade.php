{{-- resources/views/livewire/pemilu-voter.blade.php --}}
<div class="bg-gray-100 min-h-screen flex items-center justify-center p-4 antialiased">

    <div class="bg-white p-6 md:p-10 rounded-3xl shadow-2xl max-w-5xl w-full border border-gray-200">

        <header class="text-center border-b pb-4 mb-8">
            <h1 class="text-4xl font-extrabold text-blue-700 leading-snug">
                🗳️ Formulir Pemilihan Proyek Terbaik
            </h1>
            @if($activeEvent)
                <p class="mt-2 text-lg text-gray-600">Event Aktif: **{{ $activeEvent->nama }}**</p>
            @endif
        </header>
        
        @if (session()->has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded-lg shadow-md" role="alert">
                <p class="font-bold">Terjadi Kesalahan</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if ($status === 'no_event')
            <div class="text-center py-12 bg-yellow-50 rounded-xl border border-yellow-200">
                <h2 class="text-2xl font-bold text-yellow-800">Tidak Ada Event Aktif</h2>
                <p class="text-gray-600 mt-2">Sistem pemilihan sedang tidak tersedia saat ini.</p>
            </div>

        @elseif ($status === 'already_voted')
            <div class="text-center py-12 bg-red-50 rounded-xl border border-red-200">
                <h2 class="text-2xl font-bold text-red-800">❌ Akses Ditolak</h2>
                <p class="text-gray-700 mt-2">Anda **sudah berhasil memilih** untuk event ini. Terima kasih atas partisipasi Anda.</p>
                <p class="text-sm text-gray-500 mt-1">Sistem hanya mengizinkan 1 vote per perangkat/IP.</p>
            </div>
            
        @elseif ($status === 'success')
            <div class="text-center py-16 bg-green-50 rounded-xl border border-green-200">
                <h2 class="text-4xl font-bold text-green-700">🎉 Suara Anda Berhasil Direkam!</h2>
                <p class="text-gray-700 mt-3 text-lg">Terima kasih banyak atas partisipasi Anda dalam pemilihan proyek inovasi.</p>
                
                <div class="mt-8">
                    <a href="{{ route('beranda') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 transform hover:scale-105">
                        <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2.586l.293.293a1 1 0 001.414 0l7-7a1 1 0 000-1.414l-7-7z" />
                        </svg>
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </div>

        @elseif ($status === 'form')
            
            <form wire:submit.prevent="prosesSuara">

                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">1. Tentukan Identitas Anda</h2>
                <div class="mb-8">
                    <label class="block text-base font-medium text-gray-700 mb-3">
                        Pilih kategori partisipan Anda:
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        {{-- Opsi Internal --}}
                        <label class="cursor-pointer">
                            <input type="radio" wire:model.live="tipe_voter" value="Internal" class="hidden">
                            <div class="p-5 rounded-xl border-2 transition-all duration-200 {{ $tipe_voter === 'Internal' ? 'border-blue-500 bg-blue-50 shadow-md ring-4 ring-blue-100' : 'border-gray-200 hover:border-blue-300 hover:shadow-sm' }}">
                                <h3 class="font-bold text-lg text-gray-800 flex items-center"><span class="text-3xl mr-3">🏢</span> Internal</h3>
                                <p class="text-sm text-gray-500 mt-1">Mahasiswa, Dosen, atau Staf.</p>
                            </div>
                        </label>

                        {{-- Opsi Eksternal --}}
                        <label class="cursor-pointer">
                            <input type="radio" wire:model.live="tipe_voter" value="Eksternal" class="hidden">
                            <div class="p-5 rounded-xl border-2 transition-all duration-200 {{ $tipe_voter === 'Eksternal' ? 'border-blue-500 bg-blue-50 shadow-md ring-4 ring-blue-100' : 'border-gray-200 hover:border-blue-300 hover:shadow-sm' }}">
                                <h3 class="font-bold text-lg text-gray-800 flex items-center"><span class="text-3xl mr-3">🌎</span> Eksternal</h3>
                                <p class="text-sm text-gray-500 mt-1">Perwakilan Perusahaan atau Lembaga Mitra.</p>
                            </div>
                        </label>
                    </div>
                    @error('tipe_voter') <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
                </div>
                
                @if ($tipe_voter)
                    <div class="bg-white p-6 mb-8 rounded-xl border-t-4 border-teal-500 shadow-lg">
                        <p class="font-bold text-xl text-teal-700 mb-4">Detail {{ $tipe_voter }}</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        @if ($tipe_voter === 'Internal')
                            <div>
                                <label for="kategori_internal" class="block text-sm font-medium text-gray-700 mb-1">Kategori Internal:</label>
                                <select 
                                    wire:model="kategori_internal"
                                    id="kategori_internal" 
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                >
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Mahasiswa">Mahasiswa</option>
                                    <option value="Dosen">Dosen</option>
                                    <option value="Staff">Staff</option>
                                </select>
                                @error('kategori_internal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            
                            <div>
                                <label for="identitas_voter" class="block text-sm font-medium text-gray-700 mb-1">NIM/NIP/Identitas (Wajib):</label>
                                <input 
                                    wire:model="identitas_voter"
                                    type="text" 
                                    id="identitas_voter" 
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                    placeholder="Masukkan NIM atau NIP Anda"
                                >
                                @error('identitas_voter') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                        @elseif ($tipe_voter === 'Eksternal')
                            <div>
                                <label for="identitas_voter" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap (Wajib):</label>
                                <input 
                                    wire:model="identitas_voter"
                                    type="text" 
                                    id="identitas_voter" 
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                    placeholder="Nama Lengkap Anda"
                                >
                                @error('identitas_voter') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="jabatan_eksternal" class="block text-sm font-medium text-gray-700 mb-1">Jabatan (Wajib):</label>
                                <input 
                                    wire:model="jabatan_eksternal"
                                    type="text" 
                                    id="jabatan_eksternal" 
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                    placeholder="Jabatan di Perusahaan/Lembaga"
                                >
                                @error('jabatan_eksternal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="nama_perusahaan" class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan/Lembaga (Wajib):</label>
                                <input 
                                    wire:model="nama_perusahaan"
                                    type="text" 
                                    id="nama_perusahaan" 
                                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-teal-500 focus:border-teal-500 sm:text-sm"
                                    placeholder="Contoh: PT ABC Inovasi"
                                >
                                @error('nama_perusahaan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif
                        </div>
                    </div>
                @endif
                
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">2. Pilih Proyek Terbaik</h2>
                <p class="text-sm text-gray-500 mb-6">Silakan pilih **satu** proyek dari daftar di bawah ini.</p>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($proyekLombas as $proyek)
                    <label 
                        for="proyek_{{ $proyek->id }}" 
                        class="cursor-pointer block transition duration-200 ease-in-out has-checked:ring-4 has-checked:ring-green-100 has-checked:shadow-lg"
                    >
                        <input 
                            wire:model="proyek_id_yang_dipilih"
                            type="radio" 
                            value="{{ $proyek->id }}" 
                            id="proyek_{{ $proyek->id }}" 
                            class="hidden"
                        >
                        <div class="p-5 border-2 rounded-xl h-full {{ $proyek_id_yang_dipilih == $proyek->id ? 'border-green-600 bg-green-50 shadow-md' : 'border-gray-200 hover:border-green-300 bg-white shadow-sm' }}">
                            <div class="flex flex-col">
                                
                                {{-- AREA FOTO SAMPUL YANG MENGGUNAKAN ROUTE BARU --}}
                                @if($proyek->foto_sampul)
                                    <div class="mb-4 overflow-hidden rounded-lg shadow-md aspect-video">
                                        {{-- JALUR FIX: Menggunakan route helper untuk memanggil server Laravel --}}
                                        <img 
                                            src="{{ route('proyek.image', ['filename' => $proyek->foto_sampul]) }}" 
                                            alt="Sampul Proyek {{ $proyek->nama_proyek }}"
                                            class="w-full h-full object-cover transition duration-300 hover:scale-105"
                                        >
                                    </div>
                                @else
                                    <div class="mb-4 flex flex-col items-center justify-center aspect-video bg-gray-100 rounded-lg text-gray-400 text-sm p-4">
                                        <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-12 5h12a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs">Tidak Ada Foto Sampul</span>
                                    </div>
                                @endif
                                
                                <span class="text-xs font-semibold uppercase text-blue-500 mb-1">Proyek No. {{ $loop->iteration }}</span>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">
                                    {{ $proyek->nama_proyek }}
                                </h3>
                                <p class="text-sm text-gray-600 italic mb-3">Tim: {{ $proyek->tim_pengembang ?? 'Tim Tidak Diketahui' }}</p>
                                
                                <div class="mt-auto">
                                    <p class="text-sm text-gray-500">
                                        {{ Str::limit($proyek->deskripsi, 100) }}
                                    </p>
                                </div>

                                @if ($proyek_id_yang_dipilih == $proyek->id)
                                    <span class="mt-3 text-sm font-bold text-green-600 flex items-center">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Pilihan Anda
                                    </span>
                                @endif
                            </div>
                        </div>
                    </label>
                @empty
                    <div class="lg:col-span-2 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-md shadow-sm" role="alert">
                        <p>Maaf, saat ini belum ada proyek lomba yang terdaftar untuk event ini.</p>
                    </div>
                @endforelse
                </div>

                @error('proyek_id_yang_dipilih') <p class="text-red-500 text-sm mt-4 font-medium">Anda harus memilih salah satu proyek.</p> @enderror

                @if($proyekLombas->count() > 0)
                    <button 
                        type="submit" 
                        class="mt-10 w-full py-4 bg-blue-600 text-white font-bold text-lg rounded-xl shadow-xl hover:bg-blue-700 transition duration-150 ease-in-out focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                        @if (!$tipe_voter) disabled @endif
                    >
                        <span wire:loading.remove wire:target="prosesSuara">🗳️ Rekam Pilihan Saya Sekarang</span>
                        <span wire:loading wire:target="prosesSuara">Sedang Memproses Suara...</span>
                    </button>
                @endif
            </form>
        @endif
    </div>
</div>