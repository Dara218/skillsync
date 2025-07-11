<?php

namespace App\Enums\common;

/**
 * Enums for job email tag (user_signup_code.is_updating).
 */
enum UpdateEmailTag: int
{
    /**
     * user_signup_code.is_updating = 1.
     */
    case UPDATING = 1;

    /**
     * user_signup_code.is_updating = 0.
     */
    case NOT_UPDATING = 0;
}
