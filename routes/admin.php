<?php

use App\Http\Controllers\Admin\{
    Authentication\AuthAdminController,
    Dashboard\AdminDashboardController,
};

use Illuminate\Support\Facades\Route;

Route::name('admin.')->group(function() {
    Route::prefix('admin')->group(function() {
        // Guest Routes
        Route::middleware('guest:admin')->group(function() {
            // Admin Login Routes
            Route::controller(AuthAdminController::class)
                ->name('login.')
                ->prefix('login')
                ->group(function() {
                    Route::get('/', 'index')->name('index');
                    Route::post('/', 'authenticate')->name('authenticate');
                });
        });

        // Auth admin Routes
        Route::middleware('admin')
            ->group(function() {
                // Admin Dashboard Route
                Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

                Route::prefix('logout')
                    ->group(function () {
                        Route::get('/', fn () => redirect()->route('admin.login.index'));
                        Route::post('/', [AuthAdminController::class, 'logout'])->name('logout');
                    });
            });
    });
});