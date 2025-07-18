<?php

namespace App\Service\Common;

use App\Enums\common\UserGuard;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Handles the user login process.
     *
     * @param array<mixed, string> $data
     * @param string $guard The user guard (user, admin)
     *
     * @return bool
     */
    public function handleLogin(array $data, string $guard): bool
    {
        if (!Auth::guard($guard)->attempt($data)) {
            return false;
        }

        return true;
    }
}
