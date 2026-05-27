<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add Venue') }}</h2>
                <p class="text-sm text-gray-600">Submit venue details for review by the EventNight team.</p>
            </div>
            <a href="{{ route('venue.venues.index') }}" class="text-sm text-red-600 hover:underline">Back to venues</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('venue.venues.store') }}" class="space-y-6">
                    @csrf
                    <div class="grid gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Name</label>
                            <input name="name" value="{{ old('name') }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                            <textarea name="description" rows="4" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3">{{ old('description') }}</textarea>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">City</label>
                                <input name="city" value="{{ old('city') }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Zone</label>
                                <input name="zone" value="{{ old('zone') }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Address</label>
                            <input name="address" value="{{ old('address') }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                        </div>
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Postal code</label>
                                <input name="postal_code" value="{{ old('postal_code') }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Capacity</label>
                                <input type="number" name="capacity" value="{{ old('capacity') }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Phone</label>
                                <input name="phone" value="{{ old('phone') }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-600 px-5 py-3 text-white hover:bg-red-500">Submit venue</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
