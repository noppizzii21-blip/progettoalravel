<?php

namespace App\Http\Controllers\Venue;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VenueController extends Controller
{
    public function dashboard(): View
    {
        $venues = Venue::where('user_id', auth()->id())
            ->with('events')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'approved' => $venues->where('status', 'approved')->count(),
            'pending' => $venues->where('status', 'pending')->count(),
            'rejected' => $venues->where('status', 'rejected')->count(),
        ];

        return view('venue.dashboard', compact('venues', 'stats'));
    }

    public function index(): View
    {
        $venues = Venue::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('venue.venues.index', compact('venues'));
    }

    public function create(): View
    {
        return view('venue.venues.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'zone' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'capacity' => ['required', 'integer', 'min:1'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        Venue::create(array_merge($validated, [
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]));

        return redirect()->route('venue.dashboard')->with('success', 'Venue created and sent for approval.');
    }

    public function edit(Venue $venue): View
    {
        $this->authorize('update', $venue);

        return view('venue.venues.edit', compact('venue'));
    }

    public function update(Request $request, Venue $venue): RedirectResponse
    {
        $this->authorize('update', $venue);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:255'],
            'zone' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'capacity' => ['required', 'integer', 'min:1'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $venue->update(array_merge($validated, ['status' => 'pending']));

        return redirect()->route('venue.venues.index')->with('success', 'Venue updated and set to pending approval.');
    }

    public function destroy(Venue $venue): RedirectResponse
    {
        $this->authorize('delete', $venue);

        $venue->delete();

        return redirect()->route('venue.venues.index')->with('success', 'Venue deleted.');
    }
}
