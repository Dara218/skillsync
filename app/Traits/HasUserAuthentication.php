<?php

namespace App\Traits;

use App\Enums\common\UserGuard;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait HasUserAuthentication
{
    /**
     * Get the authenticated user from the user guard.
     *
     * @return ?\App\Models\User returned
     */
    protected function getAuthUser(): ?User
    {
        return Auth::guard(UserGuard::USER->value)->user();
    }

    /**
     * Get the authenticated user as a collection from the user guard.
     *
     * @param array|null $only Specific fields to include (optional)
     *
     * @return Collection
     */
    protected function getAuthUserAsCollection(?array $only = null): Collection
    {
        $user = collect(Auth::guard(UserGuard::USER->value)->user());

        return $only ? $user->only($only) : $user;
    }
}
