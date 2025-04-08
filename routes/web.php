<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
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
    Route::middleware('role:guest')->group(function () {
        Route::view('/guest/dashboard', 'pages.dashboard')->name('dashboard');
    });
});

// Routes pour la gestion des utilisateurs (admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/users', UserController::class);

    // Route::view('/users', 'livewire.pages.admin.user-list')->name('users');
    // Route::view('/users/create', 'livewire.pages.admin.user-create')->name('users.create');
    // Route::view('/users/{user}/edit', 'livewire.pages.admin.user-edit')->name('users.edit');
});

// Routes pour la gestion des événements
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/events', EventController::class);
});
// Routes pour la gestion des invités
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/guests/import', [GuestController::class, 'import'])->name('guests.import');
    Route::get('/guests/export', [GuestController::class, 'export'])->name('guests.export');
    Route::get('/guests/{guest}/send-invitation', [GuestController::class, 'sendInvitation'])->name('guests.send-invitation');
    Route::resource('/guests', GuestController::class);

});
// Routes pour la gestion des présences
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/attendances', AttendanceController::class);
});

Route::view('profile', 'pages.profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
