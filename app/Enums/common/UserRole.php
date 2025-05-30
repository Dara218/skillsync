<?php

namespace App\Enums\common;

/**
 * Enums for user roles (users.roles)
 */
enum UserRole: string
{
    /**
     * JOB SEEKER user type.
     */
    case JOB_SEEKER = 'JOB_SEEKER';

    /**
     * ADMIN user type.
     */
    case ADMIN = 'ADMIN';
}
