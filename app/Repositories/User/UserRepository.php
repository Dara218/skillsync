<?php

namespace App\Repositories\User;

use App\Interfaces\User\UserInterface;
use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserInterface
{
    /**
     * Constructor for initializing UserRepository.
     *
     * @param \App\Models\User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
