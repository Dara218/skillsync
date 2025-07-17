<?php

namespace App\Service\User\Profile;

use App\Interfaces\User\{
    UserInterface,
    UserRegisterCodeInterface,
};
use App\Mail\UpdateEmailMail;
use App\Service\Common\LogService;
use App\Traits\HasUserAuthentication;
use Illuminate\Support\Facades\{
    Mail,
    URL,
};

class EmailAddressService
{
    use HasUserAuthentication;

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
     * Constructor for initializing the ProfileService.
     *
     * @param \App\Interfaces\User\UserInterface $userInterface
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    /**
     * Sends email to the new provided email address.
     *
     * @param string $newEmailAddress The new email address.
     *
     * @return bool
     */
    public function handleSendEmailAddressLink(string $newEmailAddress): bool
    {
        try {
            $user = $this->getAuthUserAsCollection(['name', 'email']);

            // Generate a signed route with expiration
            $url = $this->generateSignedEmailUpdateUrl($user['email'], $newEmailAddress);

            // Generate user code for email verification
            $emailData = $this->buildEmailData(
                $user->toArray(),
                $newEmailAddress,
                $url,
            );

            Mail::to($newEmailAddress)->send(new UpdateEmailMail($emailData));

            return true;
        } catch (\Exception $e) {
            LogService::error(
                'Error updating user email address.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return false;
        }
    }

    /**
     * Generates a signed URL for email update confirmation.
     *
     * @param string $oldEmailAddress The current email address of the user
     * @param string $newEmailAddress The new provided email address
     *
     * @return string
     */
    protected function generateSignedEmailUpdateUrl(string $oldEmailAddress, string $newEmailAddress): string
    {
        return URL::temporarySignedRoute(
            'user.profile.update.email',
            now()->addDay(),
            [
                'new_email' => $newEmailAddress,
                'old_email' => $oldEmailAddress,
                'ts' => now()->timestamp,
            ],
        );
    }

    /**
     * Builds the data array passed to the email view.
     *
     * @param array $user The auth user contains (email, name)
     * @param string $newEmailAddress The new provided email address
     * @param string $url The url of the update email process
     *
     * @return array<mixed, string>
     */
    protected function buildEmailData(
        array $user,
        string $newEmailAddress,
        string $url
    ): array {
        return [
            'email' => $newEmailAddress,
            'old_email' => $user['email'],
            'name' => $user['name'],
            'url' => $url,
        ];
    }

    /**
     * Updates the user email address data in database.
     *
     * @param string $newEmailAddress The new email address
     * @param string $userId The id of the authenticated user
     *
     * @return void
     */
    public function handleUpdateEmailAddress(string $newEmailAddress, string $userId): void
    {
        try {
            $userId = $this->getAuthUser()->id;

            // Update email in users.email
            $this->userInterface->update($userId, [
                'email' => $newEmailAddress,
            ]);
        } catch (\Exception $e) {
            LogService::error(
                'Error updating user email address.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );
        }
    }
}
