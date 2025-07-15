<?php

if (!function_exists('formatFileName')) {
    /**
     * Formats the file name from s3 folder.
     *
     * @param string $systemUserImagePath The system file path
     * @param string $username The username of the auth user
     * @param string $fileName The filename of the file being processed
     *
     * @return string
     */
    function formatFileName(
        string $systemUserImagePath,
        string $username,
        string $fileName,
    ): string {
        return $systemUserImagePath . "$username/" . $fileName;
    }
}
