<?php

namespace App\Http\Middleware;

use App\Enums\common\UserGuard;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $guard): Response
    {
        if (Auth::guard($guard)->check()) {
            $route = null;

            switch ($guard) {
                case UserGuard::ADMIN->value:
                    // Todo: Update this
                    $route = route('test');
                    break;
                case UserGuard::USER->value:
                default:
                    $route = route('user.dashboard');
                    break;
            }

            return redirect($route);
        }

        return $next($request);
    }
}
