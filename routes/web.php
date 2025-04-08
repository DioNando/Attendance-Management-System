<?php

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

Route::view('profile', 'pages.profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
