<?php

namespace App\Interfaces\User;

use App\Interfaces\BaseInterface;
use App\Models\UserSignupCode;
use Illuminate\Database\Eloquent\Collection;

interface UserRegisterCodeInterface extends BaseInterface
{
    /**
     * Get user login code data by code.
     *
     * @param string $code (user_login_code.code)
     *
     * @return \App\Models\UserSignupCode
     */
    public function getByCode(string $code): UserSignupCode;

    /**
     * Summary of getLatest
     *
     * @return \App\Models\UserSignupCode
     */
    public function getLatest(): UserSignupCode;
}
