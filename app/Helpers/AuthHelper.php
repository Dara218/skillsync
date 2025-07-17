<?php

if (!function_exists('getAuthUser')) {
    /**
     * Get the authenticated user from the user guard.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function getAuthUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return Auth::guard(\App\Enums\common\UserGuard::USER->value)->user();
    }
}

if (!function_exists('getAuthUserId')) {
    /**
     * Get the authenticated user ID from the user guard.
     *
     * @return int|string|null
     */
    function getAuthUserId(): int|string|null
    {
        return Auth::guard(\App\Enums\common\UserGuard::USER->value)->id();
    }
}

if (!function_exists('getAuthUserAsCollection')) {
    /**
     * Get the authenticated user as a collection from the user guard.
     *
     * @param array|null $only Specific fields to include (optional)
     * @return \Illuminate\Support\Collection
     */
    function getAuthUserAsCollection(?array $only = null): \Illuminate\Support\Collection
    {
        $user = collect(Auth::guard(\App\Enums\common\UserGuard::USER->value)->user());
        
        return $only ? $user->only($only) : $user;
    }
}

if (!function_exists('isUserAuthenticated')) {
    /**
     * Check if a user is authenticated with the user guard.
     *
     * @return bool
     */
    function isUserAuthenticated(): bool
    {
        return Auth::guard(\App\Enums\common\UserGuard::USER->value)->check();
    }
}