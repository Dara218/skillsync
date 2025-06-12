<?php

use App\Http\Controllers\Registration\UserRegistrationController;
use App\Http\Controllers\User\{
    Authentication\AuthUserController,
    Dashboard\UserDashboardController,
};
use App\Http\Controllers\User\VerifyEmail\UserVerifyController;
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

            // User Registration Routes
            Route::controller(UserRegistrationController::class)
                ->prefix('/register')
                ->name('register.')
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'store')->name('store');
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
        // User Verification Route
        Route::controller(UserVerifyController::class)
            ->prefix('user-verify')
            ->name('verify.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/', 'verify')->name('process');
            });
    });
});
