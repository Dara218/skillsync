<?php

namespace App\Traits;

use App\Enums\common\UserGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

trait HasUserAuthentication
{
    /**
     * Get the authenticated user from the user guard.
     *
     * @return Authenticatable|null
     */
    protected function getAuthUser(): ?Authenticatable
    {
        return Auth::guard(UserGuard::USER->value)->user();
    }

    /**
     * Get the authenticated user ID from the user guard.
     *
     * @return int|string|null
     */
    protected function getAuthUserId(): int|string|null
    {
        return Auth::guard(UserGuard::USER->value)->id();
    }

    /**
     * Get the authenticated user as a collection from the user guard.
     *
     * @param array|null $only Specific fields to include (optional)
     * @return Collection
     */
    protected function getAuthUserAsCollection(?array $only = null): Collection
    {
        $user = collect(Auth::guard(UserGuard::USER->value)->user());
        
        return $only ? $user->only($only) : $user;
    }

    /**
     * Check if a user is authenticated with the user guard.
     *
     * @return bool
     */
    protected function isUserAuthenticated(): bool
    {
        return Auth::guard(UserGuard::USER->value)->check();
    }

    /**
     * Get the user guard instance.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    protected function getUserGuard(): \Illuminate\Contracts\Auth\Guard
    {
        return Auth::guard(UserGuard::USER->value);
    }
}