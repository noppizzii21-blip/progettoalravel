<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\Event;
use App\Models\Venue;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'pending_venues' => Venue::where('status', 'pending')->count(),
            'pending_events' => Event::where('status', 'pending')->count(),
            'approved_events' => Event::where('status', 'published')->count(),
            'approvals' => Approval::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
