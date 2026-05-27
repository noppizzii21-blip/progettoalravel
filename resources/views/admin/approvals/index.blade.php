<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pending Approvals') }}</h2>
                <p class="text-sm text-gray-600">Approve or reject venue and event submissions.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-red-600 hover:underline">Admin home</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-900 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pending Venues</h3>
                <div class="mt-6 grid gap-4">
                    @forelse($pendingVenues as $venue)
                        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 p-5 bg-gray-50 dark:bg-gray-800">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $venue->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $venue->city }} · {{ $venue->zone }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.approvals.venues.approve', $venue) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-green-600 text-white text-sm hover:bg-green-500">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.approvals.venues.reject', $venue) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-500">Reject</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800 p-6 text-gray-500 dark:text-gray-300">
                            There are no venue approvals waiting.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pending Events</h3>
                <div class="mt-6 grid gap-4">
                    @forelse($pendingEvents as $event)
                        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 p-5 bg-gray-50 dark:bg-gray-800">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $event->title }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Venue: {{ $event->venue?->name ?? 'Unknown' }} · {{ $event->date->format('M d, Y') }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.approvals.events.approve', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-green-600 text-white text-sm hover:bg-green-500">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.approvals.events.reject', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-500">Reject</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800 p-6 text-gray-500 dark:text-gray-300">
                            There are no event approvals waiting.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
