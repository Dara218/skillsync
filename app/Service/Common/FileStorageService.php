<?php

namespace App\Service\Common;

use App\Interfaces\User\UserInterface;
use App\Service\Common\S3Service;
use App\Traits\HasUserAuthentication;
use Illuminate\Http\UploadedFile;

class FileStorageService
{
    use HasUserAuthentication;

    /**
     * UserInterface instance.
     *
     * @var \App\Interfaces\User\UserInterface $userInterface
     */
    protected UserInterface $userInterface;

    /**
     * S3Service instance.
     *
     * @var \App\Service\Common\S3Service $s3Service
     */
    protected S3Service $s3Service;

    /**
     * Constructor for initializing the FileStorageService.
     *
     * @param \App\Interfaces\User\UserInterface $userInterface
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
        $this->s3Service = app(S3Service::class);
    }

    /**
     * Handles the file upload.
     *
     * @param \Illuminate\Http\UploadedFile The file being processed
     * @param string $systemPath The default path of the file in the system
     * @param ?string $userFilePath The path file saved in user's table
     * @param string $column The column to be updated in the user's table
     * @param array<mixed, string> The user containing id, username, and path to be updated
     *
     * @return void
     */
    public function upload(
        UploadedFile $uploadedFile,
        string $systemPath,
        ?string $userFilePath,
        string $column,
        array $user,
    ): void {
        if (
            $systemPath
            && $userFilePath
            && $this->s3Service->exists($userFilePath)
        ) {
            $this->s3Service->delete($userFilePath);
        }

        $filePath = formatFileName(
            $systemPath,
            $user['username'],
            $uploadedFile->getClientOriginalName(),
        );

        // Get the raw contents of the uploaded file so it can be uploaded to a remote storage service
        $file = file_get_contents($uploadedFile->getRealPath());

        // Upload the file in s3 folder
        $this->s3Service->put($filePath, $file);

        // Update the file path in users table
        $this->updateFilePath(
            $user['id'],
            $filePath,
            $column,
        );
    }

    /**
     * Update the user path in db.
     *
     * @param integer $userId The user's id (users.id)
     * @param ?string $filePath The file path to be updated in user's table
     * @param string $column The column to be updated in the user's table
     *
     * @return void
     */
    public function updateFilePath(
        int $userId,
        ?string $filePath,
        string $column,
    ): void {
        $this->userInterface->update(
            $userId,
            [$column => $filePath],
        );
    }

    /**
     * Handles the file delete.
     *
     * @param \Illuminate\Http\UploadedFile $userFilePath The file being processed
     * @param string $column The column to be updated in the user's table
     *
     * @return void
     */
    public function delete(string $userFilePath, string $column): void
    {
        $user = $this->getAuthUser();

        if ($userFilePath && $this->s3Service->exists($userFilePath)) {
            $this->s3Service->delete($userFilePath);
        }

        $this->updateFilePath(
            $user->id,
            null,
            $column,
        );
    }
}
