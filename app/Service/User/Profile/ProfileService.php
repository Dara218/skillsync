<?php

namespace App\Service\User\Profile;

use App\Interfaces\User\{
    UserInterface,
    UserRegisterCodeInterface,
};
use App\Service\Common\LogService;

class ProfileService
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
     * Constructor for initializing the ProfileService.
     *
     * @param \App\Interfaces\User\UserInterface $userInterface
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    /**
     * Handle user profile update.
     *
     * @param array $data The personal details of the user
     * @param int $id The user's id (users.id)
     *
     * @return bool
     */
    public function updateProfile(array $data, int $id): bool
    {
        try {
            $this->userInterface->update($id, $data);

            return true;
        } catch (\Exception $e) {
            LogService::error(
                'Error updating user profile.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return false;
        }
    }
}
