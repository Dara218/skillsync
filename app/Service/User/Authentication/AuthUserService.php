<?php

namespace App\Service\User\Authentication;

use App\Enums\common\UserGuard;
use Illuminate\Support\Facades\Auth;

class AuthUserService
{
    /**
     * Handles the user login process.
     *
     * @param array<mixed, string> $data
     *
     * @return bool
     */
    public function handleLogin(array $data): bool
    {
        $guard = UserGuard::USER->value;

        if (!Auth::guard($guard)->attempt($data)) {
            return false;
        }

        return true;
    }
}
