<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Event') }}</h2>
                <p class="text-sm text-gray-600">Update event details and resubmit for review.</p>
            </div>
            <a href="{{ route('organizer.events.index') }}" class="text-sm text-red-600 hover:underline">Back to events</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('organizer.events.update', $event) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Title</label>
                            <input name="title" value="{{ old('title', $event->title) }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Venue</label>
                            <select name="venue_id" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3">
                                <option value="">Select venue</option>
                                @foreach($venues as $venue)
                                    <option value="{{ $venue->id }}" @selected(old('venue_id', $event->venue_id) == $venue->id)>{{ $venue->name }} — {{ $venue->city }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('venue_id')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                            <textarea name="description" rows="4" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3">{{ old('description', $event->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">City</label>
                                <input name="city" value="{{ old('city', $event->city) }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Zone</label>
                                <input name="zone" value="{{ old('zone', $event->zone) }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Address</label>
                            <input name="address" value="{{ old('address', $event->address) }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                        </div>
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Date</label>
                                <input type="date" name="date" value="{{ old('date', $event->date->format('Y-m-d')) }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Time</label>
                                <input type="time" name="time" value="{{ old('time', $event->time->format('H:i')) }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Min age</label>
                                <input type="number" name="min_age" value="{{ old('min_age', $event->min_age) }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Max participants</label>
                                <input type="number" name="max_participants" value="{{ old('max_participants', $event->max_participants) }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Access type</label>
                                <select name="access_type" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3">
                                    <option value="free" @selected(old('access_type', $event->access_type) === 'free')>Free</option>
                                    <option value="presale" @selected(old('access_type', $event->access_type) === 'presale')>Presale</option>
                                    <option value="waiting_list" @selected(old('access_type', $event->access_type) === 'waiting_list')>Waiting List</option>
                                    <option value="open" @selected(old('access_type', $event->access_type) === 'open')>Open Access</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Presale price</label>
                                <input type="number" step="0.01" name="presale_price" value="{{ old('presale_price', $event->presale_price) }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Presale quantity</label>
                            <input type="number" name="presale_quantity" value="{{ old('presale_quantity', $event->presale_quantity) }}" class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white p-3" />
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-600 px-5 py-3 text-white hover:bg-red-500">Update event</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
