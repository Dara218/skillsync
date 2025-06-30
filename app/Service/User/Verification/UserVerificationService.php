<?php

namespace App\Service\User\Verification;

use App\Enums\common\UserGuard;
use App\Exceptions\{
    CodeLatestException,
    CodeExpiredException,
};
use App\Interfaces\User\{
    UserInterface,
    UserRegisterCodeInterface,
};
use App\Mail\UserRegister;
use App\Service\Common\LogService;
use App\Service\User\Registration\UserRegisterService;
use Carbon\Carbon;
use Illuminate\Support\Facades\{
    Auth,
    Mail,
};

class UserVerificationService
{
    /**
     * UserRegisterCodeInterface instance.
     *
     * @var \App\Interfaces\User\UserRegisterCodeInterface $verifyCodeInterface
     */
    protected UserRegisterCodeInterface $verifyCodeInterface;

    /**
     * UserRegisterService instance.
     *
     * @var \App\Service\User\Registration\UserRegisterService $userRegisterService
     */
    protected UserRegisterService $userRegisterService;

    /**
     * UserRegisterService instance.
     *
     * @var \App\Interfaces\User\UserInterface $userInterface
     */
    protected UserInterface $userInterface;

    /**
     * Constructor for initializing UserVerificationService.
     *
     * @param \App\Interfaces\User\UserRegisterCodeInterface $verifyCodeInterface
     */
    public function __construct(UserRegisterCodeInterface $verifyCodeInterface)
    {
        $this->verifyCodeInterface = $verifyCodeInterface;
        $this->userRegisterService = app(UserRegisterService::class);
        $this->userInterface = app(UserInterface::class);
    }

    /**
     * Handles the user verification process.
     *
     * @param string $code Code entered by the user (user_login_code.code)
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function handleVerification(string $code): bool
    {
        try {
            $data = $this->verifyCodeInterface->getByCode($code);

            // Get the latest verification code data
            $latestSignupCode = $this->verifyCodeInterface->getLatest();

            $this->checkIfLatestAndExpired($data->code, $latestSignupCode->code);

            // Check if verification code is still valid
            $isCodeValid = $this->checkCodeValidity(
                $data,
                $latestSignupCode->code,
            );

            if ($isCodeValid) {
                $this->updateEmailVerifiedAt();
            };

            // Todo: Add re-send verification code feature.

            return $isCodeValid;
        } catch (CodeLatestException $e) {
            // Re-throw custom exceptions so controller can catch them
            throw $e;
        } catch (\Exception $e) {
            LogService::error(
                'Error processing the code verification.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return false;
        }
    }

    /**
     * Check if verification code is still valid.
     *
     * @param string $code The code entered by the user
     * @param string $latestCode The latest code from the database associated with the user (user_signup_code.code)
     *
     * @return void
     *
     * @throws \App\Exceptions\CodeLatestException
     */
    private function checkIfLatestAndExpired(string $code, string $latestCode): void
    {
        if ($code !== $latestCode) {
            throw new CodeLatestException(__('validation.custom.old_verification_code'));
        }
    }

    /**
     * Check if the code is not expired.
     *
     * @param mixed $data The user_signup_code data
     * @param string $codeCreationDate The latest verification code of the user from database
     *
     * @return bool
     *
     * @throws CodeExpiredException
     */
    private function checkCodeValidity(
        mixed $data,
        string $latestSignupCode,
    ): bool {
        try {
            $date = Carbon::parse($data->created_at);
            $isCodeExpired = $date->diffInHours(now()) > 24;

            if ($isCodeExpired && $data->code === $latestSignupCode) {
                // Generate a new verification code to database
                $newVerificationCode = $this->userRegisterService
                    ->generateRegisterCode($data->email);

                // If latest data is expired, generate new email
                Mail::to($data->email)->send(new UserRegister(
                    $data->only('email', 'name'),
                    $newVerificationCode,
                ));

                return false;
            }

            if ($isCodeExpired) {
                throw new CodeExpiredException(__('validation.custom.old_and_expired_verification_code'));
            }

            return true;
        } catch (CodeExpiredException $e) {
            throw $e;
        } catch (\Exception $e) {
            LogService::error(
                'Error processing the code validity.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            throw $e;
        }
    }

    /**
     * Updates the email_verified_at column in users table.
     *
     * @return void
     */
    private function updateEmailVerifiedAt(): void
    {
        $this->userInterface->update(
            Auth::guard(UserGuard::USER->value)->user()->id,
            ['email_verified_at' => now()],
        );
    }
}
