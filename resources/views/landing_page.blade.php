<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Voting Proyek Inovasi - Dashboard Real-Time</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex flex-col items-center p-4 lg:p-10">
        
        <div class="max-w-6xl w-full">
            
            {{-- BAGIAN 1: HEADER & CALL TO ACTION (Focal Point) --}}
            <div class="text-center py-10 mb-8 bg-white rounded-xl shadow-lg border-t-8 border-blue-600">
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight">
                    <span class="text-blue-600">Sistem E-Voting</span> Proyek Inovasi
                </h1>
                <p class="mt-3 text-lg text-gray-600">
                    Platform Pemungutan Suara Elektronik Cepat, Akurat, dan Transparan.
                </p>

                @if(session('error'))
                    <div class="max-w-xl mx-auto mt-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md" role="alert">
                        <p class="font-bold">Pemberitahuan</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif
                
                {{-- Tombol Utama yang Jelas --}}
                <div class="mt-8">
                    <a href="{{ route('voting.form') }}" 
                       class="inline-flex items-center px-10 py-4 border border-transparent text-xl font-bold rounded-full shadow-2xl text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-300 transition duration-300 transform hover:scale-105">
                        🗳️ Berikan Suara Anda Sekarang
                    </a>
                </div>
            </div>
            
            {{-- BAGIAN 2: REAL-TIME RESULT (FULL WIDTH) --}}
            <div class="bg-white p-6 sm:p-8 rounded-xl shadow-2xl border border-gray-200">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 flex items-center border-b pb-3">
                    <svg class="w-7 h-7 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    Dashboard Hasil Real-Time
                </h2>
                
                {{-- Komponen Livewire mengambil seluruh lebar --}}
                @livewire('hasil-voting-live')

            </div>
            
            {{-- FOOTER / LINK ADMIN --}}
            <div class="text-center mt-8 pt-4 border-t border-gray-300">
                <a href="/admin" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition duration-150">Akses Admin Panel</a>
            </div>

        </div>
    </div>
    @livewireScripts
</body>
</html>