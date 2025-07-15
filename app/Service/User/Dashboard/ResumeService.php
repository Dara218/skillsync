<?php

namespace App\Service\User\Dashboard;

use App\Enums\common\UserGuard;
use App\Interfaces\User\UserInterface;
use App\Service\Common\{
    FileStorageService,
    LogService,
    S3Service,
};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ResumeService
{
    /**
     * FileStorageService instance.
     *
     * @var \App\Service\Common\FileStorageService $fileStorageService
     */
    protected FileStorageService $fileStorageService;

    /**
     * UserInterface instance.
     *
     * @var \App\Interfaces\User\UserInterface $userInterface
     */
    protected UserInterface $userInterface;

    /**
     * The s3 channel name.
     */
    public const CHANNEL_NAME = 's3';

    /**
     * The resume_path in the user's table.
     */
    public const RESUME_PATH = 'resume_path';

    /**
     * Constructor for initializing ResumeController.
     *
     * @param \App\Service\Common\S3Service $s3Service
     */
    public function __construct(S3Service $s3Service)
    {
        $this->userInterface = app(UserInterface::class);
        $this->fileStorageService = app(FileStorageService::class);
    }

    /**
     * Handles the resume upload.
     *
     * @param \Illuminate\Http\UploadedFile $resume
     *
     * @return void
     */
    public function handleResumeUpload(UploadedFile $resume): void
    {
        try {
            $systemResumePath = config('filesystems.paths.resume');

            $user = collect(Auth::guard(UserGuard::USER->value)->user())
                ->only(['id', 'username', self::RESUME_PATH])
                ->toArray();

            $currentImagePath = $user[self::RESUME_PATH];

            $this->fileStorageService->upload(
                $resume,
                $systemResumePath,
                $currentImagePath,
                self::RESUME_PATH,
                $user,
            );
        } catch (\Exception $e) {
            LogService::error(
                'Error uploading the resume.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
                self::CHANNEL_NAME,
            );
        }
    }

    /**
     * Handles the resume delete.
     *
     * @return void
     */
    public function handleResumeDelete(): void
    {
        try {
            $user = Auth::guard(UserGuard::USER->value)->user();
            $currentResumePath = $user->resume_path;

            $this->fileStorageService->delete(
                $currentResumePath,
                self::RESUME_PATH,
            );
        } catch (\Exception $e) {
            LogService::error(
                'Error deleting the resume.',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
                self::CHANNEL_NAME,
            );
        }
    }
}
