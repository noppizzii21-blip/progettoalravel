<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\TicketSale;
use App\Models\Venue;
use App\Models\WaitingList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\StripeClient;

class EventBrowseController extends Controller
{
    public function home(): View
    {
        $featuredEvents = Event::published()
            ->with('venue')
            ->withApprovedVenue()
            ->whereDate('date', '>=', today())
            ->orderBy('date')
            ->take(6)
            ->get();

        $featuredVenues = Venue::approved()
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('public.home', compact('featuredEvents', 'featuredVenues'));
    }

    public function index(Request $request): View
    {
        $query = Event::published()
            ->with('venue')
            ->withApprovedVenue()
            ->whereDate('date', '>=', today());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn ($sub) => $sub
                ->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
            );
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('zone')) {
            $query->where('zone', $request->zone);
        }

        if ($request->filled('access_type')) {
            $query->where('access_type', $request->access_type);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $events = $query->orderBy('date')->paginate(9)->withQueryString();
        $zones = Event::select('zone')->distinct()->orderBy('zone')->pluck('zone');

        return view('events.index', compact('events', 'zones'));
    }

    public function show(Event $event): View
    {
        abort_unless($event->isPublished(), 404);

        return view('events.show', compact('event'));
    }

    public function purchase(Request $request, Event $event): RedirectResponse
    {
        if (! in_array($event->access_type, ['presale', 'open'], true)) {
            return back()->with('error', 'Ticket purchase is not available for this event.');
        }

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        if (! $event->presale_price || $event->presale_price <= 0) {
            return back()->with('error', 'This event does not offer ticket sales at this time.');
        }

        $stripe = new StripeClient(config('services.stripe.secret'));

        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => (int) ($event->presale_price * 100),
            'currency' => 'usd',
            'payment_method_types' => ['card'],
            'metadata' => [
                'event_id' => $event->id,
                'user_id' => auth()->id(),
            ],
        ]);

        TicketSale::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'quantity' => $request->quantity,
            'total_price' => $event->presale_price * $request->quantity,
            'stripe_payment_id' => $paymentIntent->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Stripe checkout created. Use test card 4242 4242 4242 4242 to complete payment.');
    }

    public function join(Event $event): RedirectResponse
    {
        if ($event->access_type !== 'waiting_list') {
            return back()->with('error', 'Waiting list registration is not open for this event.');
        }

        $already = WaitingList::where('event_id', $event->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($already) {
            return back()->with('info', 'You are already on the waiting list.');
        }

        $position = WaitingList::where('event_id', $event->id)->count() + 1;

        WaitingList::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'position' => $position,
        ]);

        return back()->with('success', 'You have been added to the waiting list.');
    }
}
