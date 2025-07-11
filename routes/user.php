<?php

use App\Http\Controllers\User\{
    Authentication\AuthUserController,
    Dashboard\ResumeController,
    Dashboard\UserDashboardController,
    Job\JobsController,
    Profile\ProfileController,
    Registration\UserRegistrationController,
    VerifyEmail\UserVerifyController,
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

        // Resume Route
        Route::controller(ResumeController::class)
            ->prefix('resume')
            ->name('resume.')
            ->group(function() {
                Route::put('/upload', 'upload')->name('upload');
                Route::delete('/delete', 'delete')->name('delete');
            });

        // Jobs Routes
        Route::controller(JobsController::class)
            ->name('jobs.')
            ->prefix('/jobs')
            ->group(function() {
                Route::get('/', 'index')->name('index');
            });

        // Update Profile Routes
        Route::controller(ProfileController::class)
            ->name('profile.')
            ->prefix('/profile')
            ->group(function() {
                Route::get('/{username}', 'index')->name('index');
                Route::name('update.')
                    ->prefix('/update')
                    ->group(function () {
                        Route::put('/{id}', 'update')
                            ->name('personal-info')
                            ->where(['id' => '[0-9]+']);
                        Route::get('/update-email', 'viewUpdateEmailPage')->name('show-update-email');
                        Route::post('/update-email', 'sendEmailAddressLink')->name('send-email');
                        Route::get('/update-email-process', 'updateEmailAddress')->name('email');
                    });
            });
    });
});
