<?php

namespace App\Traits;

use App\Enums\common\UserGuard;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

trait HasAdminAuthentication
{
    /**
     * Get the authenticated user from the user guard.
     *
     * @return ?\App\Models\User returned
     */
    protected function getAuthAdmin(): ?User
    {
        return Auth::guard(UserGuard::ADMIN->value)->user();
    }

    /**
     * Get the authenticated user as a collection from the user guard.
     *
     * @param array|null $only Specific fields to include (optional)
     *
     * @return Collection
     */
    protected function getAuthAdminAsCollection(?array $only = null): Collection
    {
        $user = collect(Auth::guard(UserGuard::ADMIN->value)->user());

        return $only ? $user->only($only) : $user;
    }
}
