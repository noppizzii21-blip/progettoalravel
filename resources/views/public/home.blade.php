<x-app-layout>
    @php
        $heroImage = 'https://images.unsplash.com/photo-1497032628192-86f99bcd76bc?auto=format&fit=crop&w=1600&q=80';
        $cardImages = [
            'https://images.unsplash.com/photo-1518609878373-06d740f60d8b?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1497032628192-86f99bcd76bc?auto=format&fit=crop&w=1200&q=80',
            'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80'
        ];
        $testimonials = [
            ['name' => 'Giulia Rossi', 'role' => 'Frequent Eventgoer', 'text' => 'EventNight trasforma ogni uscita in una serata perfetta. La selezione di eventi è pazzesca e la UX è elegantissima.'],
            ['name' => 'Marco Bianchi', 'role' => 'DJ Producer', 'text' => 'La piattaforma è incredibilmente fluida, ideale per promuovere serate e gestire vendite in modo professionale.'],
            ['name' => 'Sara Conti', 'role' => 'Festival Lover', 'text' => 'Ho trovato i migliori festival della mia città in pochi click. Grafica top e ottima navigazione.']
        ];
    @endphp

    <section class="relative isolate overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-slate-950/85"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(56,189,248,0.22),_transparent_24%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_10%,_rgba(168,85,247,0.18),_transparent_20%)]"></div>
            <div class="absolute inset-0" style="background-image:url('{{ $heroImage }}'); background-size: cover; background-position: center; opacity: 0.35;"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-[1.2fr_0.8fr] items-center">
                <div class="space-y-8">
                    <p class="inline-flex rounded-full bg-slate-800/70 px-4 py-2 text-sm font-semibold uppercase tracking-[0.3em] text-sky-300/90 shadow-lg shadow-sky-500/10">Eventi live & nightlife</p>
                    <div class="space-y-6">
                        <h1 class="max-w-3xl text-5xl font-semibold tracking-tight text-white sm:text-6xl">Scopri gli eventi più esclusivi vicino a te</h1>
                        <p class="max-w-xl text-lg leading-8 text-slate-300">Vivi serate indimenticabili con festival, concerti, DJ set e conferenze curate per un pubblico che cerca solo il meglio.</p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('events.index') }}" class="btn-primary">Sfoglia eventi</a>
                        <a href="{{ route('register') }}" class="btn-secondary">Inizia ora</a>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="glass-card p-6">
                            <p class="text-sm uppercase tracking-[0.26em] text-slate-400">Prossimo evento</p>
                            <p class="mt-4 text-2xl font-semibold text-white">3/03 - DJ set esclusivo a Milano</p>
                        </div>
                        <div class="glass-card p-6">
                            <p class="text-sm uppercase tracking-[0.26em] text-slate-400">Live crowd</p>
                            <p class="mt-4 text-2xl font-semibold text-white">12K+ partecipanti</p>
                        </div>
                    </div>
                </div>

                <div class="glass-panel overflow-hidden p-0 shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1518609878373-06d740f60d8b?auto=format&fit=crop&w=1200&q=80" alt="Hero event" class="h-full w-full object-cover" />
                </div>
            </div>
        </div>
    </section>

    <section id="popular" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-sky-300">Eventi popolari</p>
                <h2 class="mt-3 text-3xl font-semibold text-white">Gli eventi più richiesti della settimana</h2>
            </div>
            <a href="{{ route('events.index') }}" class="btn-secondary">Vedi tutti</a>
        </div>

        <div class="mt-10 grid gap-8 lg:grid-cols-3">
            @foreach($featuredEvents as $event)
                @php $image = $cardImages[$loop->index % count($cardImages)]; @endphp
                <article class="glass-card overflow-hidden hover:-translate-y-1 transition duration-300">
                    <div class="relative overflow-hidden">
                        <img src="{{ $image }}" alt="{{ $event->title }}" class="h-64 w-full object-cover transition duration-500 hover:scale-105" />
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-slate-950/95 via-slate-950/40 to-transparent p-4">
                            <span class="card-tag">{{ ucfirst(str_replace('_', ' ', $event->access_type ?? 'live')) }}</span>
                        </div>
                    </div>
                    <div class="space-y-4 p-6">
                        <div class="flex items-center justify-between gap-4 text-xs uppercase tracking-[0.2em] text-slate-400">
                            <span>{{ $event->date?->format('d M') ?? 'TBD' }}</span>
                            <span>{{ $event->city }}, {{ $event->zone }}</span>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-2xl font-semibold text-white">{{ $event->title }}</h3>
                            <p class="text-sm leading-6 text-slate-300 line-clamp-3">{{ $event->description }}</p>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-3 pt-4 text-sm text-slate-300">
                            <span class="rounded-full bg-slate-900/80 px-3 py-2">Prezzo: {{ $event->presale_price ? '€' . number_format($event->presale_price, 2) : 'Free' }}</span>
                            <a href="{{ route('events.show', $event) }}" class="text-sky-300 hover:text-white">Scopri di più →</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section id="categories" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-sm uppercase tracking-[0.3em] text-sky-300">Categorie</p>
            <h2 class="mt-3 text-3xl font-semibold text-white">Scegli il tuo mood</h2>
            <p class="mx-auto mt-4 max-w-2xl text-slate-400">Festival, DJ set, concerti pop, conferenze business e serate private. Ogni evento è selezionato per un pubblico premium.</p>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
            @foreach(['Concerti', 'Festival', 'Nightlife', 'Business'] as $category)
                <div class="glass-card p-8 text-center">
                    <p class="text-sm uppercase tracking-[0.3em] text-sky-300">{{ $category }}</p>
                    <h3 class="mt-5 text-2xl font-semibold text-white">{{ $category }}</h3>
                    <p class="mt-4 text-slate-400">Scopri esperienze premium, line up selezionati e ambienti esclusivi per ogni stile.</p>
                </div>
            @endforeach
        </div>
    </section>

    <section id="testimonials" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-sm uppercase tracking-[0.3em] text-sky-300">Testimonianze</p>
            <h2 class="mt-3 text-3xl font-semibold text-white">Chi ha già scelto EventNight</h2>
            <p class="mx-auto mt-4 max-w-2xl text-slate-400">Esperienze reali di chi ha già partecipato ai migliori eventi in città.</p>
        </div>

        <div class="mt-12 grid gap-6 lg:grid-cols-3">
            @foreach($testimonials as $item)
                <div class="glass-card p-8">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-white">{{ $item['name'] }}</h3>
                            <p class="mt-1 text-sm text-slate-400">{{ $item['role'] }}</p>
                        </div>
                        <div class="h-14 w-14 rounded-2xl bg-slate-900/90 p-3 text-center text-lg font-semibold text-slate-200">{{ strtoupper(substr($item['name'],0,1)) }}</div>
                    </div>
                    <p class="mt-6 text-slate-300">“{{ $item['text'] }}”</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-24 sm:px-6 lg:px-8">
        <div class="glass-panel flex flex-col gap-8 p-10 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-sky-300">Sei pronto?</p>
                <h2 class="mt-3 text-3xl font-semibold text-white">Inizia la tua prossima esperienza</h2>
                <p class="mt-4 max-w-2xl text-slate-400">Registrati oggi e accedi ai migliori eventi, offerte esclusive e agli ingressi VIP per le serate più calde.</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('register') }}" class="btn-primary">Crea account</a>
                <a href="{{ route('events.index') }}" class="btn-secondary">Scopri eventi</a>
            </div>
        </div>
    </section>

</x-app-layout>
