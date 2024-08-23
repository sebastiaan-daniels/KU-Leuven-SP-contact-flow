<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <meta name="description" content="{{ $description ?? 'Welkom bij het Servicepunt.' }}">
    <title>ICTS Servicepunt: {{ $title ?? 'Servicepunt' }}</title>
    <x-layout.favicons/>
</head>
<body class="font-sans antialiased">
<div class="flex flex-col space-y-4 min-h-screen text-gray-800 bg-gray-100">
    <header class="shadow bg-white/70 sticky inset-0 backdrop-blur-sm z-10">
        {{--  Navigation  --}}
        <nav class="container mx-auto p-4 flex justify-between">
            {{-- left navigation--}}
            <div class="flex items-center space-x-2">
                {{-- Logo --}}
                <a href="{{ route('home') }}">
                    <x-icts.logo class="w-8 h-8"/>
                </a>
                <a class="hidden sm:block font-medium text-lg" href="{{ route('home') }}">
                    ICTS Servicepunt
                </a>
                <x-nav-link href="{{ route('under-construction') }}" :active="request()->routeIs('under-construction')">
                    Contact flow
                </x-nav-link>
                <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">
                    Contact
                </x-nav-link>
            </div>

            {{-- right navigation --}}
            <div class="relative flex items-center space-x-2">
                <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                    Login
                </x-nav-link>

                {{-- dropdown navigation--}}
                <x-dropdown align="right" width="48">
                    {{-- avatar --}}
                    <x-slot name="trigger">
                        <img class="rounded-full h-8 w-8 cursor-pointer"
                             src="https://ui-avatars.com/api/?name=Admin"
                             alt="Admin">
                    </x-slot>
                    <x-slot name="content">
                        {{-- all users --}}
                        <div class="block px-4 py-2 text-xs text-gray-400">My Name</div>
                        <x-dropdown-link href="{{ route('under-construction') }}">Dashboard</x-dropdown-link>
                        <x-dropdown-link href="{{ route('profile.show') }}">Update Profile</x-dropdown-link>
                        <x-dropdown-link href="{{ route('under-construction') }}">UC</x-dropdown-link>
                        <div class="border-t border-gray-100"></div>
                        <x-dropdown-link href="{{ route('under-construction') }}">Logout</x-dropdown-link>
                        <div class="border-t border-gray-100"></div>
                        {{-- admins only --}}
                        <div class="block px-4 py-2 text-xs text-gray-400">Admin</div>
                        <x-dropdown-link href="{{ route('under-construction') }}">UC</x-dropdown-link>
                        <x-dropdown-link href="{{ route('under-construction') }}">UC</x-dropdown-link>
                        <x-dropdown-link href="{{ route('under-construction') }}">UC</x-dropdown-link>
                        <x-dropdown-link href="{{ route('under-construction') }}">UC</x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
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

