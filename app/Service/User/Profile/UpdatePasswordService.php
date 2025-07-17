<?php

namespace App\Service\User\Profile;

use App\Interfaces\User\UserInterface;
use App\Service\Common\LogService;

class UpdatePasswordService
{
    /**
     * UserInterface instance.
     *
     * @var \App\Interfaces\User\UserInterface $userInterface
     */
    protected UserInterface $userInterface;

    /**
     * Constructor for initializing the UpdatePasswordService.
     *
     * @param \App\Interfaces\User\UserInterface $userInterface
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    /**
     * Handle user password update.
     *
     * @param int $id The user's id (users.id)
     * @param array $data The personal details of the user
     *
     * @return bool
     */
    public function handleUpdate(int $id, array $data): bool
    {
        try {
            $this->userInterface->update($id, $data);

            return true;
        } catch (\Exception $e) {
            LogService::error(
                'Error updating user password.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            );

            return false;
        }
    }
}
