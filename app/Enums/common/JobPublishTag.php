<?php

namespace App\Enums\common;

/**
 * Enums for job publish tag (jobs.is_published).
 */
enum JobPublishTag: int
{
    /**
     * jobs.is_published = 1.
     */
    case PUBLISHED = 1;

    /**
     * jobs.is_published = 0.
     */
    case UNPUBLISHED = 0;
}
