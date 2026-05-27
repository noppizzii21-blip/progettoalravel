<nav x-data="{ open: false, scrolled: false }" x-init="scrolled = window.scrollY > 24; window.addEventListener('scroll', () => scrolled = window.scrollY > 24)" :class="scrolled ? 'bg-slate-950/95 border-b border-slate-800 shadow-2xl backdrop-blur-xl' : 'bg-transparent'" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-lg font-semibold text-white">
                <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 via-violet-500 to-fuchsia-500 text-sm font-bold shadow-[0_15px_40px_-25px_rgba(59,130,246,0.8)]">E</span>
                <span>EventNight</span>
            </a>
            <div class="hidden lg:flex items-center gap-6 text-sm font-medium text-slate-300">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <a href="{{ route('events.index') }}" class="hover:text-white transition">Eventi</a>
                <a href="{{ route('home') }}#categories" class="hover:text-white transition">Categorie</a>
                <a href="{{ route('home') }}#testimonials" class="hover:text-white transition">Testimonianze</a>
            </div>
        </div>

        <div class="hidden items-center gap-3 lg:flex">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-secondary">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium text-slate-200 hover:text-white transition">Login</a>
                <a href="{{ route('register') }}" class="btn-primary">Registrati</a>
            @endauth
        </div>

        <button @click="open = ! open" class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-slate-950/80 p-3 text-slate-200 shadow-lg shadow-slate-950/40 transition duration-200 hover:bg-slate-900 lg:hidden">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div x-show="open" x-transition class="border-t border-slate-800 bg-slate-950/95 lg:hidden">
        <div class="space-y-2 px-4 py-4 text-sm text-slate-200">
            <a href="{{ route('home') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-900 transition">Home</a>
            <a href="{{ route('events.index') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-900 transition">Eventi</a>
            <a href="{{ route('home') }}#categories" class="block rounded-2xl px-4 py-3 hover:bg-slate-900 transition">Categorie</a>
            <a href="{{ route('home') }}#testimonials" class="block rounded-2xl px-4 py-3 hover:bg-slate-900 transition">Testimonianze</a>
            @auth
                <a href="{{ route('dashboard') }}" class="block rounded-2xl bg-slate-800 px-4 py-3 text-center text-slate-100 transition hover:bg-slate-700">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="block rounded-2xl px-4 py-3 hover:bg-slate-900 transition">Login</a>
                <a href="{{ route('register') }}" class="block rounded-2xl bg-gradient-to-r from-sky-500 via-violet-500 to-fuchsia-500 px-4 py-3 text-center text-white transition hover:opacity-95">Registrati</a>
            @endauth
        </div>
    </div>
</nav>
