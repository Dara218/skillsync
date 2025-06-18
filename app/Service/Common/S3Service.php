<?php

namespace App\Service\Common;

use Illuminate\Support\Facades\Storage;

class S3Service
{
    /**
     * Filesystem instance.
     *
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $s3;

    /**
     * Channel for logging
     *
     * @var string
     */
    protected $channel = 's3';

    /**
     * Constructor initializing S3Service.
     */
    public function __construct()
    {
        $this->s3 = Storage::disk('s3');
    }

    /**
     * Saves the file contents to S3 in the specified directory and filename.
     *
     * @param string $filepath The file path of the file
     * @param mixed $contents The file content to be uploaded
     * @param mixed $options
     *
     * @return bool
     */
    public function put(
        string $filepath,
        mixed $contents,
        mixed $options = [],
    ): bool {
        try {
            $result = $this->s3->put(
                $filepath,
                $contents,
                $options,
            );

            return $result;
        } catch (\Exception $e) {
            LogService::error(
                'Error Uploading file to S3',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
                $this->channel,
            );

            return false;
        }
    }

    /**
     * Checks if a file exists given a filepath.
     *
     * @param string $filepath
     *
     * @return bool
     */
    public function exists(string $filepath): bool
    {
        $result = $this->s3->exists($filepath);

        return $result;
    }

    /**
     * Gets the contents of a file. If a file doesn't exist, returns null.
     *
     * @param string $filepath
     *
     * @return string|null
     */
    public function get(string $filepath): string|null
    {
        try {
            $result = $this->s3->get($filepath);

            return $result;
        } catch (\Exception $e) {
            LogService::error(
                'Error getting file from S3',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
                $this->channel,
            );

            return null;
        }
    }

    /**
     * Attempts to delete file(s) at the given filepath(s).
     * Input can be a string (for single file) or an array (for multiple files).
     *
     * @param array<string>|string $filepaths
     *
     * @return bool
     */
    public function delete(array|string $filepaths): bool
    {
        try {
            $result = $this->s3->delete($filepaths);

            return $result;
        } catch (\Exception $e) {
            LogService::error(
                'Error deleting file from S3',
                [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
                $this->channel,
            );

            return false;
        }
    }
}
