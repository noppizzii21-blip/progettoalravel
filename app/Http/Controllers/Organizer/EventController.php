<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function dashboard(): View
    {
        $events = Event::where('user_id', auth()->id())
            ->with('venue')
            ->orderBy('date')
            ->get();

        $stats = [
            'published' => $events->where('status', 'published')->count(),
            'pending' => $events->where('status', 'pending')->count(),
            'rejected' => $events->where('status', 'rejected')->count(),
        ];

        return view('organizer.dashboard', compact('events', 'stats'));
    }

    public function index(): View
    {
        $events = Event::where('user_id', auth()->id())
            ->with('venue')
            ->orderBy('date')
            ->paginate(10);

        return view('organizer.events.index', compact('events'));
    }

    public function create(): View
    {
        $this->authorize('create', Event::class);

        $venues = Venue::approved()->orderBy('name')->get();

        return view('organizer.events.create', compact('venues'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Event::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'venue_id' => ['required', 'exists:venues,id'],
            'city' => ['required', 'string', 'max:255'],
            'zone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'min_age' => ['nullable', 'integer', 'min:0'],
            'max_participants' => ['nullable', 'integer', 'min:1'],
            'access_type' => ['required', 'in:free,presale,waiting_list,open'],
            'presale_price' => ['nullable', 'numeric', 'min:0'],
            'presale_quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        Event::create(array_merge($validated, [
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]));

        return redirect()->route('organizer.dashboard')->with('success', 'Event created and is pending approval.');
    }

    public function edit(Event $event): View
    {
        $this->authorize('update', $event);

        $venues = Venue::approved()->orderBy('name')->get();

        return view('organizer.events.edit', compact('event', 'venues'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'venue_id' => ['required', 'exists:venues,id'],
            'city' => ['required', 'string', 'max:255'],
            'zone' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'min_age' => ['nullable', 'integer', 'min:0'],
            'max_participants' => ['nullable', 'integer', 'min:1'],
            'access_type' => ['required', 'in:free,presale,waiting_list,open'],
            'presale_price' => ['nullable', 'numeric', 'min:0'],
            'presale_quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $event->update($validated);

        return redirect()->route('organizer.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('organizer.events.index')->with('success', 'Event deleted.');
    }
}
