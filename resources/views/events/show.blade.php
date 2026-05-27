<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $event->title }}</h2>
                <p class="text-sm text-gray-600">{{ $event->city }} · {{ $event->zone }} · {{ $event->venue?->name ?? 'Venue pending' }}</p>
            </div>
            <a href="{{ route('events.index') }}" class="text-sm text-red-600 hover:underline">Back to events</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 p-4 text-green-800 dark:text-green-200 mb-6">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 p-4 text-red-800 dark:text-red-200 mb-6">{{ session('error') }}</div>
                @endif
                @if(session('info'))
                    <div class="rounded-lg bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 p-4 text-blue-800 dark:text-blue-200 mb-6">{{ session('info') }}</div>
                @endif

                <div class="grid gap-8 lg:grid-cols-[2fr_1fr]">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">{{ $event->description }}</p>

                        <div class="mt-6 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-3xl border border-gray-200 dark:border-gray-800 p-5 bg-gray-50 dark:bg-gray-800">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Date</div>
                                <div class="mt-2 font-semibold text-gray-900 dark:text-white">{{ $event->date->format('F j, Y') }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $event->time->format('H:i') }}</div>
                            </div>
                            <div class="rounded-3xl border border-gray-200 dark:border-gray-800 p-5 bg-gray-50 dark:bg-gray-800">
                                <div class="text-sm text-gray-500 dark:text-gray-400">Access</div>
                                <div class="mt-2 font-semibold text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $event->access_type)) }}</div>
                                @if($event->presale_price)
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Presale price</div>
                                    <div class="font-semibold text-gray-900 dark:text-white">${{ number_format($event->presale_price, 2) }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 p-6 bg-gray-50 dark:bg-gray-800">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Venue</p>
                            <h3 class="mt-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $event->venue?->name ?? 'Pending approval' }}</h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ $event->venue?->address ?? 'TBD' }}</p>
                        </div>

                        @auth
                            @if($event->access_type === 'presale' || $event->access_type === 'open')
                                <form method="POST" action="{{ route('events.purchase', $event) }}" class="space-y-4">
                                    @csrf
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Quantity</label>
                                    <input type="number" name="quantity" min="1" value="1" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                                    <button type="submit" class="w-full rounded-lg bg-red-600 text-white px-4 py-3 hover:bg-red-500">Purchase with Stripe</button>
                                </form>
                            @elseif($event->access_type === 'waiting_list')
                                <form method="POST" action="{{ route('events.join', $event) }}">
                                    @csrf
                                    <button type="submit" class="w-full rounded-lg bg-indigo-600 text-white px-4 py-3 hover:bg-indigo-500">Join Waiting List</button>
                                </form>
                            @else
                                <div class="rounded-3xl border border-gray-200 dark:border-gray-800 p-6 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                    This event is free and open to all guests.
                                </div>
                            @endif
                        @else
                            <div class="rounded-3xl border border-gray-200 dark:border-gray-800 p-6 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                                <p class="text-sm mb-4">Log in to purchase tickets or join the waiting list.</p>
                                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md">Log in</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
