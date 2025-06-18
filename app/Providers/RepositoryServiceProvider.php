<?php

namespace App\Providers;

use App\Interfaces\Application\ApplicationInterface;
use App\Interfaces\Job\JobInterface;
use App\Interfaces\User\{
    UserInterface,
    UserRegisterCodeInterface,
};
use App\Repositories\Application\ApplicationRepository;
use App\Repositories\Job\JobRepository;
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
        $this->app->bind(
            JobInterface::class,
            JobRepository::class,
        );
        $this->app->bind(
            ApplicationInterface::class,
            ApplicationRepository::class,
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
