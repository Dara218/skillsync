<?php

namespace App\Services;

use App\Enums\common\UserGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

class AuthUserService
{
    /**
     * Get the authenticated user from the user guard.
     *
     * @return Authenticatable|null
     */
    public function getUser(): ?Authenticatable
    {
        return Auth::guard(UserGuard::USER->value)->user();
    }

    /**
     * Get the authenticated user ID from the user guard.
     *
     * @return int|string|null
     */
    public function getUserId(): int|string|null
    {
        return Auth::guard(UserGuard::USER->value)->id();
    }

    /**
     * Get the authenticated user as a collection from the user guard.
     *
     * @param array|null $only Specific fields to include (optional)
     * @return Collection
     */
    public function getUserAsCollection(?array $only = null): Collection
    {
        $user = collect(Auth::guard(UserGuard::USER->value)->user());
        
        return $only ? $user->only($only) : $user;
    }

    /**
     * Check if a user is authenticated with the user guard.
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return Auth::guard(UserGuard::USER->value)->check();
    }

    /**
     * Get the user guard instance.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function getGuard(): \Illuminate\Contracts\Auth\Guard
    {
        return Auth::guard(UserGuard::USER->value);
    }

    /**
     * Get a specific attribute from the authenticated user.
     *
     * @param string $attribute
     * @param mixed $default
     * @return mixed
     */
    public function getUserAttribute(string $attribute, mixed $default = null): mixed
    {
        $user = $this->getUser();
        
        return $user ? $user->{$attribute} ?? $default : $default;
    }
}