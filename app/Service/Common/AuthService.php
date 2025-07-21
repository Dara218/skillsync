<?php

namespace App\Service\Common;

use App\Enums\common\UserGuard;
use App\Models\User;
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

        // Update last login timestamp for user guard
        if ($guard === UserGuard::USER->value) {
            /** @var User $user */
            $user = Auth::guard($guard)->user();
            $user?->updateLastLogin();
        }

        return true;
    }
}
