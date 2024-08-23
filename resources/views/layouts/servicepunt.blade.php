<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta name="description" content="{{ $description ?? 'Welkom bij het Servicepunt.' }}">
    <title>ICTS Servicepunt: {{ $title ?? 'Servicepunt' }}</title>
</head>
<body class="font-sans antialiased">
<div class="flex flex-col space-y-4 min-h-screen text-gray-800 bg-gray-100">
    <header class="shadow bg-white/70 sticky inset-0 backdrop-blur-sm z-10">
        {{--  Navigation  --}}
        <nav class="container mx-auto p-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="underline">Home</a>
            <a href="{{ route('under-construction') }}" class="underline">Contact flow volgen</a>
            <a href="{{ route('login') }}" class="underline">Login</a>
        </nav>
    </header>
    <main class="container mx-auto p-4 flex-1 px-4">
        {{-- Title --}}
        <h1 class="text-3xl mb-4">
            {{ $subtitle ?? $title ?? "This page has no (sub)title" }}
        </h1>
        {{-- Main content --}}
        {{ $slot }}
    </main>
    <footer class="container mx-auto p-4 text-sm border-t flex justify-between items-center">
        <div>ICTS KULeuven - © {{ date('Y') }}</div>
        <div>Built with ❤ by S.D.</div>
    </footer>
</div>
@stack('script')
@livewireScripts
</body>
</html>
