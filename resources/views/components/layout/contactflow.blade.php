<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta name="description" content="{{ $description ?? 'Welkom bij het Servicepunt.' }}">
    <title>ICTS Servicepunt: {{ $title ?? 'Servicepunt' }}</title>
    <x-layout.favicons/>
</head>
<body class="font-sans antialiased">
<div class="flex flex-col space-y-4 min-h-screen text-gray-800 bg-white">
    <main class="container mx-auto p-4 flex-1 px-4">
        {{-- Main content --}}
        {{ $slot }}
    </main>

</div>
@stack('script')
@livewireScripts
</body>
</html>

