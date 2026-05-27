<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TicketSale;
use App\Models\WaitingList;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $tickets = TicketSale::with('event')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $waitingList = WaitingList::with('event')
            ->where('user_id', auth()->id())
            ->orderBy('position')
            ->get();

        return view('user.dashboard', compact('tickets', 'waitingList'));
    }
}
