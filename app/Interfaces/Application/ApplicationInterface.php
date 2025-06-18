<?php

namespace App\Interfaces\Application;

use App\Interfaces\BaseInterface;
use Illuminate\Database\Eloquent\Collection;

interface ApplicationInterface extends BaseInterface
{
    /**
     * Get the recent application for the user.
     *
     * @param int $userId The user id (users.id)
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecent(int $userId): Collection;
}
