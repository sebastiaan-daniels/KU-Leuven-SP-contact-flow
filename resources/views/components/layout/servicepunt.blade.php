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
                <x-nav-link href="{{ route('contactflow') }}"
                data-tippy-content="De CF heeft geen header/footer: Het is een component van de ICTS pagina">
                    Contact flow
                </x-nav-link>
                <x-nav-link href="{{ route('contact') }}" :active="request()->routeIs('contact')">
                    Contact
                </x-nav-link>
            </div>

            {{-- right navigation --}}

            <div class="relative flex items-center space-x-2">
                @guest
                <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                    Login
                </x-nav-link>
                @endguest

                @auth
                {{-- dropdown navigation--}}
                <x-dropdown align="right" width="48">
                    {{-- avatar --}}
                    <x-slot name="trigger">
                        <img class="rounded-full h-8 w-8 cursor-pointer"
                             src="https://ui-avatars.com/api/?name={{  urlencode(auth()->user()->name) }}"
                             alt="{{ auth()->user()->name }}">
                    </x-slot>
                    <x-slot name="content">
                        {{-- all users --}}
                        <div class="block px-4 py-2 text-xs text-gray-400">Welkom, {{ auth()->user()->name }}</div>
{{--                        <x-dropdown-link href="{{ route('dashboard') }}">Dashboard</x-dropdown-link>--}}
                        <x-dropdown-link href="{{ route('profile.show') }}">Update Profile</x-dropdown-link>
                        <x-dropdown-link href="{{ route('user.contacts') }}">Contacten beheren</x-dropdown-link>
                        <x-dropdown-link href="{{ route('user.questions') }}">Vragen beheren</x-dropdown-link>

                        @if(auth()->user()->admin)
{{--                            For future reference--}}
{{--                        --}}{{-- admins only --}}
{{--                            <div class="border-t border-gray-100"></div>--}}
{{--                        <div class="block px-4 py-2 text-xs text-gray-400">Admin</div>--}}
{{--                        <x-dropdown-link href="{{ route('under-construction') }}">UC</x-dropdown-link>--}}
{{--                        <x-dropdown-link href="{{ route('under-construction') }}">UC</x-dropdown-link>--}}
{{--                        <x-dropdown-link href="{{ route('under-construction') }}">UC</x-dropdown-link>--}}
{{--                        <x-dropdown-link href="{{ route('under-construction') }}">UC</x-dropdown-link>--}}
                        @endif
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">Logout</button>
                        </form>

                    </x-slot>
                </x-dropdown>
                    @endauth
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
        <div>version 1.0-rc.1</div>
        <div><a href="mailto:contact@sebastiaandaniels.com">Built with ❤ by S.D.</a></div>

    </footer>
</div>
@stack('script')
@livewireScripts
</body>
</html>

