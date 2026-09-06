<?php

use App\Http\Controllers\AssistantController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestBookingController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
| Three areas, three prefixes. The public site at the root, a guest's own space under
| /my, and the staff desk under /desk. The desk is gated by the `access-desk` Gate through
| the `can` middleware; each desk resource is then authorized per record by its Policy.
*/

// public site
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/availability', [HomeController::class, 'availability'])->name('availability');
Route::post('/assistant', AssistantController::class)->middleware('throttle:assistant')->name('assistant');
Route::post('/assistant/reset', [AssistantController::class, 'reset'])->name('assistant.reset');

// a guest's own space
Route::middleware(['auth', 'verified'])->prefix('my')->group(function () {
    Route::get('/', fn () => auth()->user()->is_staff
        ? redirect()->route('staff.dashboard')
        : view('guest.dashboard'))->name('dashboard');

    Route::get('/bookings', [GuestBookingController::class, 'index'])->name('guest.bookings');
    Route::get('/book', [GuestBookingController::class, 'create'])->name('guest.booking.create');
    Route::post('/book', [GuestBookingController::class, 'store'])->name('guest.booking.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// the staff desk
Route::middleware(['auth', 'verified', 'can:access-desk'])->prefix('desk')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('staff.dashboard');

    Route::resource('rooms', RoomController::class);
    Route::resource('guests', GuestController::class);
    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store', 'show']);
    Route::patch('bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
});

require __DIR__.'/auth.php';
