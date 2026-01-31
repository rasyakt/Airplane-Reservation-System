<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Admin\AirportController;
use App\Http\Controllers\Admin\AircraftController;
use App\Http\Controllers\Admin\AircraftManufacturerController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\FlightController;
use App\Http\Controllers\Admin\FlightSeatPriceController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [BookingController::class, 'index'])->name('home');
Route::get('/flights/search', [BookingController::class, 'search'])->name('flights.search');
Route::get('/flights/{flight}', [BookingController::class, 'show'])->name('flights.show');
// Booking routes
Route::post('/bookings/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
Route::get('/bookings/payment/{confirmationCode}', [BookingController::class, 'payment'])->name('bookings.payment');
Route::post('/bookings/payment/{confirmationCode}', [BookingController::class, 'processPayment'])->name('bookings.payment.process');
Route::get('/bookings/confirmation/{confirmationCode}', [BookingController::class, 'confirmation'])->name('bookings.confirmation');

// Authenticated routes
Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('airports', AirportController::class);
        Route::resource('aircraft', AircraftController::class);
        Route::resource('manufacturers', AircraftManufacturerController::class);
        Route::resource('schedules', ScheduleController::class);
        Route::resource('flights', FlightController::class);
        Route::get('prices', [FlightSeatPriceController::class, 'index'])->name('prices.index');
        Route::get('prices/{flight}/edit', [FlightSeatPriceController::class, 'edit'])->name('prices.edit');
        Route::put('prices/{flight}', [FlightSeatPriceController::class, 'update'])->name('prices.update');
        Route::resource('bookings', \App\Http\Controllers\Admin\AdminBookingController::class)->only(['index', 'show', 'destroy']);
    });
});

require __DIR__ . '/auth.php';

