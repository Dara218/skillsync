<?php

namespace App\Repositories\User;

use App\Interfaces\User\UserRegisterCodeInterface;
use App\Models\UserLoginCode;
use App\Repositories\BaseRepository;

class UserRegisterCodeRepository extends BaseRepository implements UserRegisterCodeInterface
{
    /**
     * Constructor for initializing UserRegisterCodeRepository.
     *
     * @param \App\Models\UserLoginCode $model
     */
    public function __construct(UserLoginCode $model)
    {
        parent::__construct($model);
    }
}
