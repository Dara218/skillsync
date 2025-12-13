<?php

namespace App\Traits;

use Carbon\Carbon;

trait TracksLastLogin
{
    /**
     * Update the user's last login timestamp.
     *
     * @return bool
     */
    public function updateLastLogin(): bool
    {
        return $this->update(['last_login' => now()]);
    }

    /**
     * Update the user's last login timestamp with a custom timestamp.
     *
     * @param \Carbon\Carbon|null $timestamp
     *
     * @return bool
     */
    public function updateLastLoginAt(?Carbon $timestamp = null): bool
    {
        return $this->update(['last_login' => $timestamp ?? now()]);
    }

    /**
     * Get the user's last login as a human readable format.
     *
     * @return string|null
     */
    public function getLastLoginForHumansAttribute(): ?string
    {
        return $this->last_login?->diffForHumans();
    }

    /**
     * Check if the user has logged in today.
     *
     * @return bool
     */
    public function hasLoggedInToday(): bool
    {
        if (!$this->last_login) {
            return false;
        }

        return $this->last_login->isToday();
    }

    /**
     * Get the number of days since last login.
     *
     * @return int|null
     */
    public function daysSinceLastLogin(): ?int
    {
        if (!$this->last_login) {
            return null;
        }

        return (int) $this->last_login->diffInDays(now());
    }
}