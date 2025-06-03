<?php

namespace App\Enums\common;

/**
 * Enums for job type (jobs.type)
 */
enum JobType: string
{
    /**
     * Full Time job type.
     */
    case FULL_TIME = 'FULL_TIME';

    /**
     * Part time job type.
     */
    case PART_TIME = 'PART_TIME';

    /**
     * Remote job type.
     */
    case REMOTE = 'REMOTE';

    /**
     * Internship job type.
     */
    case INTERNSHIP = 'INTERNSHIP';
}
