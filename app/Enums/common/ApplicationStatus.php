<?php

namespace App\Enums\common;

/**
 * Enums for application status (applications.status)
 */
enum ApplicationStatus: string
{
    /**
     * Pending application type.
     */
    case PENDING = 'PENDING';

    /**
     * Reviewed application type.
     */
    case REVIEWED = 'REVIEWED';

    /**
     * Accepted application type.
     */
    case ACCEPTED = 'ACCEPTED';

    /**
     * Rejected application type.
     */
    case REJECTED = 'REJECTED';
}
