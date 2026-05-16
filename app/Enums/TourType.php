<?php

namespace App\Enums;

/**
 * Tour types.
 */
enum TourType: string
{
    case GROUP = 'group';
    case PRIVATE = 'private';
    case SOLO = 'solo';
    case GUARANTEED = 'guaranteed';

    /**
     * Get the human-readable label.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::GROUP => 'Group',
            self::PRIVATE => 'Private',
            self::SOLO => 'Solo',
            self::GUARANTEED => 'Guaranteed',
        };
    }

    /**
     * Get the Filament color name.
     *
     * @return string
     */
    public function color(): string
    {
        return match ($this) {
            self::GROUP => 'info',
            self::PRIVATE => 'warning',
            self::SOLO => 'gray',
            self::GUARANTEED => 'success',
        };
    }
}
