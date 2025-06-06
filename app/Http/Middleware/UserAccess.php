<?php

namespace App\Http\Middleware;

use App\Enums\common\UserGuard;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = UserGuard::USER->value;

        if (Auth::guard($guard)->check()) {
            return $next($request);
        }

        return redirect()->route('user.login.index');
    }
}
