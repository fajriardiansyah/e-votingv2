{{-- resources/views/voting/livewire_wrapper.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Voting - Pemilihan Langsung</title>
    {{-- Menautkan CSS/Tailwind --}}
    @vite('resources/css/app.css') 
</head>
<body>
    {{-- Memanggil komponen Livewire. Ini adalah Halaman Utama Voting Anda. --}}
    @livewire('pemilu-voter') 
</body>
</html>