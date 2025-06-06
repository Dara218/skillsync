<?php

use App\Http\Controllers\User\{
    Authentication\AuthUserController,
    Dashboard\UserDashboardController,
};
use Illuminate\Support\Facades\Route;

Route::name('user.')->group(function () {
    Route::prefix('user')->group(function () {
        // Guest routes
        Route::middleware('guest:user')->group(function () {
            // Login Routes
            Route::controller(AuthUserController::class)
                ->name('login.')
                ->prefix('login')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'authenticate')->name('authenticate');
            });
        });

        // Auth user routes
        Route::middleware('user')->group(function () {
            // Logout Routes
            Route::prefix('logout')
                ->group(function () {
                    Route::get('/', fn () => redirect()->route('user.login.index'));
                    Route::post('/', [AuthUserController::class, 'logout'])->name('logout');
                });
        });
    });

    // Auth user routes
    Route::middleware('user')->group(function () {
        // Dashboard Route
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    });
});