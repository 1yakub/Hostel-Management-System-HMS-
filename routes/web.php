<?php

use App\Http\Controllers\AssistantController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestBookingController;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/availability', [HomeController::class, 'availability'])->name('availability');
Route::post('/assistant', AssistantController::class)->middleware('throttle:assistant')->name('assistant');
Route::post('/assistant/reset', [AssistantController::class, 'reset'])->name('assistant.reset');

// Guest Booking Routes
Route::get('/book-now', [GuestBookingController::class, 'create'])->name('guest.booking.create');
Route::post('/book-now', [GuestBookingController::class, 'store'])->name('guest.booking.store');

// Guest Routes (authenticated users)
Route::middleware(['auth', 'verified'])->group(function () {
    // Guest Dashboard
    Route::get('/dashboard', function () {
        return auth()->user()->is_staff
            ? redirect()->route('staff.dashboard')
            : view('guest.dashboard');
    })->name('dashboard');

    Route::get('/my-bookings', [GuestBookingController::class, 'index'])->name('guest.bookings');
    Route::get('/book-now', [GuestBookingController::class, 'create'])->name('guest.booking.create');
    Route::post('/book-now', [GuestBookingController::class, 'store'])->name('guest.booking.store');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Staff Routes
Route::middleware(['auth', 'verified', 'staff'])->group(function () {
    Route::get('/staff/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');

    Route::resource('rooms', RoomController::class);
    Route::resource('guests', GuestController::class);
    Route::resource('bookings', BookingController::class);
    Route::patch('/bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
});

require __DIR__ . '/auth.php';
