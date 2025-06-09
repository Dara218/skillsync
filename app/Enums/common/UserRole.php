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

    /**
     * Get the corresponding Japanese name for each enum case.
     *
     * @return string
     */
    public function toJapanese(): string
    {
        return match ($this) {
            self::JOB_SEEKER => __('lang.enums.user_role.job_seeker'),
            self::ADMIN => __('lang.enums.user_role.admin'),
        };
    }

    /**
     * Get the list of all enum values.
     *
     * @return array<mixed, string>
     */
    public static function list(): array
    {
        return array_map(fn(self $enum) => $enum->value, UserRole::cases());
    }
}
