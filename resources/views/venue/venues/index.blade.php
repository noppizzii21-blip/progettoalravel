<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('My Venues') }}</h2>
                <p class="text-sm text-gray-600">Maintain your venue listings and approval status.</p>
            </div>
            <a href="{{ route('venue.venues.create') }}" class="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-500">New Venue</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid gap-4">
                    @forelse($venues as $venue)
                        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 p-5 bg-gray-50 dark:bg-gray-800">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $venue->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($venue->status) }} · {{ $venue->city }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('venue.venues.edit', $venue) }}" class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">Edit</a>
                                    <form action="{{ route('venue.venues.destroy', $venue) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 rounded-lg bg-red-600 text-white text-sm hover:bg-red-500">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-3xl border border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800 p-6 text-gray-500 dark:text-gray-300">
                            No venues created yet.
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $venues->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
