<?php

namespace App\Service\User\Registration;

use App\Interfaces\User\{
    UserInterface,
    UserRegisterCodeInterface,
};
use App\Mail\UserRegister;
use App\Service\Common\LogService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserRegisterService
{
    /**
     * UserInterface instance.
     *
     * @var \App\Interfaces\User\UserInterface $userInterface
     */
    protected UserInterface $userInterface;

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
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
        $this->userCodeInterface = app(UserRegisterCodeInterface::class);
    }

    /**
     * Handles the user registration process.
     *
     * @param array<mixed, string> $data
     *
     * @return void
     */
    public function handleRegistration(array $data): void
    {
        try {
            $user = $this->userInterface->create($data);

            // Generate user code for email verification
            $userCode = $this->generateRegisterCode($user->email);

            // Send registration email
            Mail::to($user->email)->send(new UserRegister(
                $user->only('email', 'name'),
                $userCode,
            ));
        } catch (\Exception $e) {
            LogService::error(
                'Error processing user registration.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );
        }
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
