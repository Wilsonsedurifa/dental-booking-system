<?php

use App\Http\Controllers\Admin\AppointmentManagementController;
use App\Http\Controllers\Admin\DentistController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Patient\BookingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public & Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('landing'));

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Dashboard & Patient Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dynamic Role-Based Dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('patient.appointments');
    })->name('dashboard');

    // Multi-Step Patient Booking Flow
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/service', [BookingController::class, 'selectService'])->name('service');
        Route::post('/service', [BookingController::class, 'postService'])->name('post-service');

        Route::get('/dentist', [BookingController::class, 'selectDentist'])->name('dentist');
        Route::post('/dentist', [BookingController::class, 'postDentist'])->name('post-dentist');

        Route::get('/datetime', [BookingController::class, 'selectDateTime'])->name('datetime');
        Route::post('/datetime', [BookingController::class, 'postDateTime'])->name('post-datetime');

        Route::get('/confirm', [BookingController::class, 'confirm'])->name('confirm');
        Route::post('/confirm', [BookingController::class, 'store'])->name('store');
    });

    // Patient Appointments List & Cancel
    Route::prefix('patient')->name('patient.')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments');
        Route::post('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AppointmentManagementController::class, 'dashboard'])->name('dashboard');
    Route::resource('dentists', DentistController::class);
    Route::resource('services', ServiceController::class);
    Route::get('/appointments', [AppointmentManagementController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [AppointmentManagementController::class, 'show'])->name('appointments.show');
    Route::post('/appointments/{appointment}/status', [AppointmentManagementController::class, 'updateStatus'])->name('appointments.status');
});
