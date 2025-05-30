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
    case FULL_TIME = 'full_time';

    /**
     * Part time job type.
     */
    case PART_TIME = 'part_time';

    /**
     * Remote job type.
     */
    case REMOTE = 'remote';

    /**
     * Internship job type.
     */
    case INTERNSHIP = 'internship';
}
