<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Organizer Dashboard') }}</h2>
                <p class="text-sm text-gray-600">Manage events, review status updates, and keep your nights live.</p>
            </div>
            <a href="{{ route('organizer.events.create') }}" class="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-500">Create Event</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-sm">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Published events</p>
                    <p class="mt-4 text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['published'] }}</p>
                </div>
                <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-sm">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pending approval</p>
                    <p class="mt-4 text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['pending'] }}</p>
                </div>
                <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-sm">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Rejected events</p>
                    <p class="mt-4 text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['rejected'] }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Your Events</h3>
                <div class="mt-6 grid gap-4">
                    @forelse($events as $event)
                        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 p-5 bg-gray-50 dark:bg-gray-800">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $event->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $event->date->format('M d, Y') }} · {{ ucfirst($event->status) }}</p>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('organizer.events.edit', $event) }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Edit</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800 p-6 text-gray-500 dark:text-gray-300">
                            You have no events yet. Create one to get started.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
