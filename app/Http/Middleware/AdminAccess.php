<?php

namespace App\Http\Middleware;

use App\Enums\common\UserGuard;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard(UserGuard::ADMIN->value)->check()) {
            return redirect()->route('admin.login.index');
        }

        return $next($request);
    }
}