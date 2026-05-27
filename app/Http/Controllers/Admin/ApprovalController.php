<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ApprovalController extends Controller
{
    public function index(): View
    {
        $pendingVenues = Venue::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $pendingEvents = Event::where('status', 'pending')->with('venue')->orderBy('date')->get();

        return view('admin.approvals.index', compact('pendingVenues', 'pendingEvents'));
    }

    public function approveEvent(Event $event): RedirectResponse
    {
        $event->update(['status' => 'published']);

        Approval::create([
            'approvable_type' => Event::class,
            'approvable_id' => $event->id,
            'approver_id' => auth()->id(),
            'action' => 'approved',
            'notes' => 'Event published by approver.',
        ]);

        return back()->with('success', 'Event approved and published.');
    }

    public function rejectEvent(Event $event): RedirectResponse
    {
        $event->update(['status' => 'rejected']);

        Approval::create([
            'approvable_type' => Event::class,
            'approvable_id' => $event->id,
            'approver_id' => auth()->id(),
            'action' => 'rejected',
            'notes' => 'Event rejected by approver.',
        ]);

        return back()->with('success', 'Event rejected.');
    }

    public function approveVenue(Venue $venue): RedirectResponse
    {
        $venue->update(['status' => 'approved']);

        Approval::create([
            'approvable_type' => Venue::class,
            'approvable_id' => $venue->id,
            'approver_id' => auth()->id(),
            'action' => 'approved',
            'notes' => 'Venue approved by approver.',
        ]);

        return back()->with('success', 'Venue approved.');
    }

    public function rejectVenue(Venue $venue): RedirectResponse
    {
        $venue->update(['status' => 'rejected']);

        Approval::create([
            'approvable_type' => Venue::class,
            'approvable_id' => $venue->id,
            'approver_id' => auth()->id(),
            'action' => 'rejected',
            'notes' => 'Venue rejected by approver.',
        ]);

        return back()->with('success', 'Venue rejected.');
    }
}
