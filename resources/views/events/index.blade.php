<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Explore Events') }}</h2>
                <p class="text-sm text-gray-600">Filter by city, zone, date, and ticket type.</p>
            </div>
            <a href="{{ route('home') }}" class="text-sm text-red-600 hover:underline">Back to Home</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('events.index') }}" class="grid gap-4 lg:grid-cols-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white p-3" />

                    <div x-data="cityAutocomplete()" x-init="init({{ json_encode(request('city')) }})" class="relative">
                        <label for="city-search" class="sr-only">City</label>
                        <input
                            id="city-search"
                            type="text"
                            name="city"
                            x-model="selected"
                            @input="query = selected; searchCities()"
                            @keydown.arrow-down.prevent="move(1)"
                            @keydown.arrow-up.prevent="move(-1)"
                            @keydown.enter.prevent="choose(activeIndex)"
                            @click="open = true"
                            @click.outside="open = false"
                            placeholder="Cerca un comune italiano"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white px-4 py-3 outline-none transition focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20"
                        />

                        <input type="hidden" name="province" :value="selectedProvince">
                        <input type="hidden" name="region" :value="selectedRegion">

                        <template x-if="open && filtered.length">
                            <ul class="absolute z-40 mt-2 max-h-80 w-full overflow-auto rounded-3xl border border-gray-700 bg-gray-900/95 p-2 shadow-2xl backdrop-blur-xl">
                                <template x-for="(item, index) in filtered" :key="item.name">
                                    <li
                                        @click="choose(index)"
                                        :class="activeIndex === index ? 'bg-gray-800' : ''"
                                        class="cursor-pointer rounded-2xl px-4 py-3 transition hover:bg-gray-800"
                                    >
                                        <div class="flex items-center justify-between gap-3">
                                            <span class="font-semibold text-gray-100" x-text="item.name"></span>
                                            <span class="text-xs uppercase tracking-[0.25em] text-sky-300" x-text="item.province"></span>
                                        </div>
                                        <div class="mt-1 text-sm text-gray-400" x-text="item.region"></div>
                                    </li>
                                </template>
                            </ul>
                        </template>
                    </div>

                    <select name="zone" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white p-3">
                        <option value="">All zones</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone }}" @selected(request('zone') === $zone)>{{ $zone }}</option>
                        @endforeach
                    </select>
                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                        <input type="date" name="date" value="{{ request('date') }}" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white p-3" />
                        <select name="access_type" class="rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white p-3">
                            <option value="">Any ticket type</option>
                            <option value="free" @selected(request('access_type') === 'free')>Free</option>
                            <option value="presale" @selected(request('access_type') === 'presale')>Presale</option>
                            <option value="waiting_list" @selected(request('access_type') === 'waiting_list')>Waiting List</option>
                            <option value="open" @selected(request('access_type') === 'open')>Open Access</option>
                        </select>
                    </div>
                    <button type="submit" class="rounded-lg bg-red-600 text-white px-4 py-3">Filter</button>
                </form>

                <div class="mt-8 grid gap-6 lg:grid-cols-3">
                    @forelse($events as $event)
                        <article class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 p-6">
                            <div class="flex items-center justify-between text-xs uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">
                                <span>{{ $event->city }} · {{ $event->zone }}</span>
                                <span>{{ ucfirst(str_replace('_', ' ', $event->access_type)) }}</span>
                            </div>
                            <h3 class="mt-4 text-xl font-semibold text-gray-900 dark:text-white">{{ $event->title }}</h3>
                            <p class="mt-3 text-sm text-gray-600 dark:text-gray-300 line-clamp-4">{{ $event->description }}</p>
                            <div class="mt-5 flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                                <span>{{ $event->date->format('M d, Y') }} at {{ $event->time->format('H:i') }}</span>
                                <a href="{{ route('events.show', $event) }}" class="text-red-600 hover:underline">View details</a>
                            </div>
                        </article>
                    @empty
                        <div class="lg:col-span-3 rounded-3xl border border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 p-6 text-center text-gray-600 dark:text-gray-300">
                            No events found. Adjust your filters and try again.
                        </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
