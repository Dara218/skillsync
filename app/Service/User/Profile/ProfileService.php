<?php

namespace App\Service\User\Profile;

use App\Enums\common\UserGuard;
use App\Interfaces\User\{
    UserInterface,
    UserRegisterCodeInterface,
};
use App\Service\Common\{
    FileStorageService,
    LogService,
};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

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
     * FileStorageService instance.
     *
     * @var \App\Service\Common\FileStorageService $fileStorageService
     */
    protected FileStorageService $fileStorageService;

    /**
     * The s3 channel name.
     */
    public const CHANNEL_NAME = 's3';

    /**
     * The profile_picture_path in the user's table.
     */
    public const PROFILE_PICTURE_PATH = 'profile_picture_path';

    /**
     * Constructor for initializing the ProfileService.
     *
     * @param \App\Interfaces\User\UserInterface $userInterface
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
        $this->fileStorageService = app(FileStorageService::class);
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

    /**
     * Handles the profile picture upload.
     *
     * @param \Illuminate\Http\UploadedFile $resume
     *
     * @return void
     */
    public function handleProfilePhotoUpload(UploadedFile $imageFile): void
    {
        try {
            $systemUserImagePath = config('filesystems.paths.profile_photo');

            $user = collect(Auth::guard(UserGuard::USER->value)->user())
                ->only(['id', 'username', self::PROFILE_PICTURE_PATH])
                ->toArray();
            $currentImagePath = $user[self::PROFILE_PICTURE_PATH];

            $this->fileStorageService->upload(
                $imageFile,
                $systemUserImagePath,
                $currentImagePath,
                self::PROFILE_PICTURE_PATH,
                $user,
            );
        } catch (\Exception $e) {
            LogService::error(
                'Error uploading the photo.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
                self::CHANNEL_NAME,
            );
        }
    }

    /**
     * Handles the profile picture delete.
     *
     * @return void
     */
    public function handleProfilePhotoDelete(): void
    {
        try {
            $user = Auth::guard(UserGuard::USER->value)->user();
            $profilePhotoPath = $user->profile_picture_path;

            $this->fileStorageService->delete(
                $profilePhotoPath,
                self::PROFILE_PICTURE_PATH,
            );
        } catch (\Exception $e) {
            LogService::error(
                'Error deleting the photo.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
                self::CHANNEL_NAME,
            );
        }
    }
}
