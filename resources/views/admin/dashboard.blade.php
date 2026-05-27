<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Admin Dashboard') }}</h2>
                <p class="text-sm text-gray-600">Review pending venues and events, and keep the community live.</p>
            </div>
            <a href="{{ route('admin.approvals.index') }}" class="rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-500">Review Approvals</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-4 lg:grid-cols-4">
                <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-sm">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pending venues</p>
                    <p class="mt-4 text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['pending_venues'] }}</p>
                </div>
                <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-sm">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pending events</p>
                    <p class="mt-4 text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['pending_events'] }}</p>
                </div>
                <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-sm">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Published events</p>
                    <p class="mt-4 text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['approved_events'] }}</p>
                </div>
                <div class="rounded-3xl bg-white dark:bg-gray-900 p-6 shadow-sm">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total approvals</p>
                    <p class="mt-4 text-3xl font-semibold text-gray-900 dark:text-white">{{ $stats['approvals'] }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
