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
     * The user verify static route.
     *
     * @var string
     */
    protected const VERIFY_ROUTE = 'user.verify.index';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Auth::guard(UserGuard::USER->value);
        $isVerified = $guard->user()?->email_verified_at;
        $routename = $request->route()?->getName();
        $isNotLoggingOut = $routename !== 'user.logout';

        if ($guard->check()) {
            // If the unverified user is trying to access anything except the verify page
            if (!$isVerified && ($routename !== self::VERIFY_ROUTE && $isNotLoggingOut)) {
                return redirect()->route(self::VERIFY_ROUTE);
            }

            // If the verified user tried to access the verify user page
            if ($isVerified && $routename === self::VERIFY_ROUTE) {
                return redirect()->route('user.dashboard');
            }

            // Allow verified users OR users accessing the verify page
            return $next($request);
        }

        return redirect()->route('user.login.index');
    }
}
