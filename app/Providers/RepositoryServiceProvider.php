<?php

namespace App\Providers;

use App\Interfaces\User\{
    UserInterface,
    UserRegisterCodeInterface,
};
use App\Repositories\User\{
    UserRegisterCodeRepository,
    UserRepository,
};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserInterface::class,
            UserRepository::class,
        );
        $this->app->bind(
            UserRegisterCodeInterface::class,
            UserRegisterCodeRepository::class,
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
