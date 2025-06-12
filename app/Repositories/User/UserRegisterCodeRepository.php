<?php

namespace App\Repositories\User;

use App\Interfaces\User\UserRegisterCodeInterface;
use App\Models\UserSignupCode;
use App\Repositories\BaseRepository;

class UserRegisterCodeRepository extends BaseRepository implements UserRegisterCodeInterface
{
    /**
     * Constructor for initializing UserRegisterCodeRepository.
     *
     * @param \App\Models\UserSignupCode $model
     */
    public function __construct(UserSignupCode $model)
    {
        parent::__construct($model);
    }

    /**
     * Get user login code data by code.
     *
     * @param string $code (user_login_code.code)
     *
     * @return \App\Models\UserSignupCode
     */
    public function getByCode(string $code): UserSignupCode
    {
        return $this->model
            ->whereCode($code)
            ->firstOrFail();
    }

    /**
     * Get the latest data from the database.
     *
     * @return \App\Models\UserSignupCode
     */
    public function getLatest(): UserSignupCode
    {
        return $this->model->latest()->first();
    }
}
