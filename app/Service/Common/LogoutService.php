<?php

namespace App\Service\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutService
{
    /**
     * Handles the logout process.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $guard The guard of the user logging out (USER | ADMIN)
     *
     * @return void
     */
    public function handleLogout(Request $request, string $guard): void
    {
        Auth::guard($guard)->logout();

        $request->session()->forget($guard);
        $request->session()->regenerateToken();
    }
}
