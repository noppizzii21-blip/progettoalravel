<?php

use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Organizer\EventController as OrganizerEventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\EventBrowseController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Venue\VenueController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventBrowseController::class, 'home'])->name('home');
Route::get('/events', [EventBrowseController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventBrowseController::class, 'show'])->name('events.show');
Route::post('/events/{event}/purchase', [EventBrowseController::class, 'purchase'])->middleware('auth')->name('events.purchase');
Route::post('/events/{event}/join', [EventBrowseController::class, 'join'])->middleware('auth')->name('events.join');

Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'organizer' => redirect()->route('organizer.dashboard'),
        'venue_owner' => redirect()->route('venue.dashboard'),
        'approver' => redirect()->route('admin.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::get('/dashboard', [OrganizerEventController::class, 'dashboard'])->name('dashboard');
    Route::resource('events', OrganizerEventController::class)
        ->except(['show'])
        ->names([
            'index' => 'events.index',
            'create' => 'events.create',
            'store' => 'events.store',
            'edit' => 'events.edit',
            'update' => 'events.update',
            'destroy' => 'events.destroy',
        ]);
});

Route::middleware(['auth', 'role:venue_owner'])->prefix('venue')->name('venue.')->group(function () {
    Route::get('/dashboard', [VenueController::class, 'dashboard'])->name('dashboard');
    Route::resource('venues', VenueController::class);
});

Route::middleware(['auth', 'role:approver'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('approvals', ApprovalController::class)->only(['index']);
    Route::post('approvals/events/{event}/approve', [ApprovalController::class, 'approveEvent'])->name('approvals.events.approve');
    Route::post('approvals/events/{event}/reject', [ApprovalController::class, 'rejectEvent'])->name('approvals.events.reject');
    Route::post('approvals/venues/{venue}/approve', [ApprovalController::class, 'approveVenue'])->name('approvals.venues.approve');
    Route::post('approvals/venues/{venue}/reject', [ApprovalController::class, 'rejectVenue'])->name('approvals.venues.reject');
});

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
