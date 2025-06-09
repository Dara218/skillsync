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

    /**
     * Get the list of all enum values.
     *
     * @return array<mixed, string>
     */
    public static function list(): array
    {
        return array_map(fn(self $enum) => $enum->value, JobType::cases());
    }
}
