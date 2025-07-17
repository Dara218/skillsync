<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\{
    Facades,
    ServiceProvider,
};
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Helpers/PaginationRedirectionHelper.php');
        require_once app_path('Helpers/FileNameFormatHelper.php');
        require_once app_path('Helpers/AuthHelper.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Facades\View::composer(['user.*', 'errors.*', 'admin.*'], function (View $view) {
            $request = app(Request::class);

            $errorRedirectRoute = route('user.dashboard');

            // TODO: Set to admin route.
            // if ($request->is('admin/*')) {
            //     // $errorRedirectRoute = route('')
            // }

            $view->with(compact('errorRedirectRoute'));
        });
    }
}
