<?php

namespace App\Service\Common;

use App\Interfaces\User\UserRegisterCodeInterface;
use Illuminate\Support\Str;

class VerificationCodeService
{
    /**
     * UserRegisterCodeInterface instance.
     *
     * @var \App\Interfaces\User\UserRegisterCodeInterface $userCodeInterface
     */
    protected UserRegisterCodeInterface $userCodeInterface;

    /**
     * Constructor for initializing UserInterface.
     *
     * @param \App\Interfaces\User\UserInterface $userInterface
     */
    public function __construct(UserRegisterCodeInterface $userCodeInterface)
    {
        $this->userCodeInterface = $userCodeInterface;
    }

    /**
     * Handle process of creating a user code for verification.
     *
     * @param string $email (users.code)
     *
     * @return mixed
     */
    public function generateRegisterCode(string $email)
    {
        try {
            $data = [
                'email' => $email,
                'code' => Str::random(config('constants.user_register_code_length')),
            ];

            $this->userCodeInterface->create($data);

            return $data['code'];
        } catch (\Exception $e) {
            LogService::error(
                'Error generating register code.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );
        }
    }
}
