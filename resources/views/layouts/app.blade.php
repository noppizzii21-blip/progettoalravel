<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950 text-slate-50">
        <div class="min-h-screen bg-slate-950 pt-28">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="overflow-hidden rounded-[2rem] border border-slate-800 bg-slate-950/80 px-6 py-6 shadow-[0_30px_90px_-50px_rgba(15,23,42,0.8)] backdrop-blur-2xl">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <footer class="border-t border-slate-900/80 bg-slate-950/95 py-12 text-slate-400">
                <div class="mx-auto flex max-w-7xl flex-col gap-10 px-4 sm:px-6 lg:px-8 xl:flex-row xl:items-center xl:justify-between">
                    <div>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-xl font-semibold text-white">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 via-violet-500 to-fuchsia-500 text-sm font-bold">E</span>
                            EventNight
                        </a>
                        <p class="mt-4 max-w-xl text-sm text-slate-500">La piattaforma per i migliori eventi, festival e nightlife. Scopri, prenota e vivi serate indimenticabili.</p>
                    </div>
                    <div class="grid gap-6 sm:grid-cols-3">
                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Scopri</h3>
                            <ul class="mt-4 space-y-3 text-sm text-slate-500">
                                <li><a href="{{ route('events.index') }}" class="hover:text-white">Eventi</a></li>
                                <li><a href="{{ route('home') }}#categories" class="hover:text-white">Categorie</a></li>
                                <li><a href="{{ route('home') }}#testimonials" class="hover:text-white">Testimonianze</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Supporto</h3>
                            <ul class="mt-4 space-y-3 text-sm text-slate-500">
                                <li><a href="mailto:hello@eventnight.local" class="hover:text-white">Contattaci</a></li>
                                <li><a href="{{ route('register') }}" class="hover:text-white">Crea account</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
