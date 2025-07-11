<?php

namespace App\Service\User\Registration;

use App\Interfaces\User\{
    UserInterface,
    UserRegisterCodeInterface,
};
use App\Mail\UserRegisterMail;
use App\Service\Common\{
    LogService,
    VerificationCodeService,
};
use Illuminate\Support\Facades\Mail;

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
     * VerificationCodeService instance.
     *
     * @var \App\Service\Common\VerificationCodeService $codeService
     */
    protected VerificationCodeService $codeService;

    /**
     * Constructor for initializing UserInterface.
     *
     * @param \App\Interfaces\User\UserInterface $userInterface
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
        $this->userCodeInterface = app(UserRegisterCodeInterface::class);
        $this->codeService = app(VerificationCodeService::class);
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
            $userCode = $this->codeService->generateRegisterCode($user->email);

            // Send registration email
            Mail::to($user->email)->send(new UserRegisterMail(
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
}
