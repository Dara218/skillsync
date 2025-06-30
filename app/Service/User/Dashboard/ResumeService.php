<?php

namespace App\Service\User\Dashboard;

use App\Enums\common\UserGuard;
use App\Interfaces\User\UserInterface;
use App\Service\Common\{
    LogService,
    S3Service,
};
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class ResumeService
{
    /**
     * S3Service instance.
     *
     * @var \App\Service\Common\S3Service $s3Service
     */
    protected S3Service $s3Service;

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
     * Constructor for initializing ResumeController.
     *
     * @param \App\Service\Common\S3Service $s3Service
     */
    public function __construct(S3Service $s3Service)
    {
        $this->s3Service = $s3Service;
        $this->userInterface = app(UserInterface::class);
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
            $systemResumePath = config('constants.file_path.resume');
            $user = Auth::guard(UserGuard::USER->value)->user();
            $currentResumePath = $user->resume_path;

            if ($currentResumePath && $this->s3Service->exists($currentResumePath)) {
                $this->s3Service->delete($currentResumePath);
            }

            $resumePath = $systemResumePath . $resume->getClientOriginalName();
            $resumeFile = file_get_contents($resume->getRealPath());

            // Upload the resume in s3 folder
            $this->s3Service->put($resumePath, $resumeFile);

            // Update the users.resume_path in users table
            $this->updateResumePath($user->id, $resumePath);
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
     * Update the user's resume path in db (users.resume_path).
     *
     * @param integer $userId The user's id (users.id)
     * @param ?string $resumePath The resume's path (users.resume_path)
     *
     * @return void
     */
    public function updateResumePath(int $userId, ?string $resumePath): void
    {
        $this->userInterface->update(
            $userId,
            ['resume_path' => $resumePath],
        );
    }

    /**
     * Handles the resume delete.
     *
     * @return void
     */
    public function handleResumeDelete()
    {
        try {
            $user = Auth::guard(UserGuard::USER->value)->user();
            $currentResumePath = $user->resume_path;

            if ($currentResumePath && $this->s3Service->exists($currentResumePath)) {
                $this->s3Service->delete($currentResumePath);
            }

            // Update the users.resume_path in users table
            $this->updateResumePath($user->id, null);
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
