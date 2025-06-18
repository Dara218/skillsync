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

    /**
     * Get the corresponding Japanese name for each enum case.
     *
     * @return string
     */
    public function toJapanese(): string
    {
        return match ($this) {
            self::PENDING => __('lang.enums.application_status.pending'),
            self::REVIEWED => __('lang.enums.application_status.reviewed'),
            self::ACCEPTED => __('lang.enums.application_status.accepted'),
            self::REJECTED => __('lang.enums.application_status.rejected'),
        };
    }

    /**
     * Get the list of all enum values.
     *
     * @return array<mixed, string>
     */
    public static function list(): array
    {
        return array_map(fn(self $enum) => $enum->value, ApplicationStatus::cases());
    }
}
