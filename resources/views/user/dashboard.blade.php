<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Your Dashboard') }}</h2>
                <p class="text-sm text-gray-600">Track your tickets, joined events, and upcoming activities.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-sm">
                <h3 class="font-semibold text-lg text-gray-900 dark:text-white">Purchased Tickets</h3>
                <div class="mt-4 divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($tickets as $ticket)
                        <div class="py-4">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $ticket->event->title }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $ticket->event->date->format('F j, Y') }} · {{ $ticket->event->venue?->name }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">You have not purchased any tickets yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-sm">
                <h3 class="font-semibold text-lg text-gray-900 dark:text-white">Waiting List</h3>
                <div class="mt-4 divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($waitingList as $item)
                        <div class="py-4">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $item->event->title }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Joined {{ $item->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">You are not on any waiting lists.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
