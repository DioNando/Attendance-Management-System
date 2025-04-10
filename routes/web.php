<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScanController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(Auth::check() ? 'dashboard' : 'login');
});

Route::middleware(['auth'])->group(function () {
    // * Route de redirection
    Route::get('/dashboard', function () {
        return redirect(RouteServiceProvider::home());
    })->name('dashboard');

    // * Dashboard admin
    Route::middleware('role:admin')->group(function () {
        Route::view('/admin/dashboard', 'pages.admin.dashboard')->name('admin.dashboard');
    });

    // * Dashboard par défaut User
    // Route::middleware('role:guest')->group(function () {
    //     Route::view('/guest/dashboard', 'pages.dashboard')->name('dashboard');
    // });

    // * Profil
    Route::view('profile', 'pages.profile')->name('profile');
});

// Routes pour la gestion des utilisateurs (admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/users', UserController::class);
});

// Routes pour la gestion des événements
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/events', EventController::class);
});
// Routes pour la gestion des invités
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/guests/import', [GuestController::class, 'import'])->name('guests.import');
    Route::get('/guests/export', [GuestController::class, 'export'])->name('guests.export');
    Route::get('/guests/{event}/send-invitations', [GuestController::class, 'sendInvitations'])->name('guests.send-invitations');
    Route::resource('/guests', GuestController::class);
});
// Routes pour la gestion des présences
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/attendances', AttendanceController::class);
});

// Routes pour le scan des QR codes
Route::prefix('events/{event}/scan')->middleware(['auth'])->group(function () {
    Route::get('/', [ScanController::class, 'showScanInterface'])->name('scan.index');
    Route::get('/stats', [ScanController::class, 'scanStats'])->name('scan.stats');
});

// API endpoints
Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::get('events/{event}/recent-scans', [ScanController::class, 'getRecentScans'])->name('api.recent-scans');
});

require __DIR__ . '/auth.php';
