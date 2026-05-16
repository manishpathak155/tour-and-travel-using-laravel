<?php

namespace App\Enums;

/**
 * Tour difficulty levels.
 */
enum DifficultyLevel: string
{
    case EASY = 'easy';
    case MODERATE = 'moderate';
    case MODERATE_STRENUOUS = 'moderate_strenuous';
    case STRENUOUS = 'strenuous';
    case EXTREME = 'extreme';

    /**
     * Get the human-readable label.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::EASY => 'Easy',
            self::MODERATE => 'Moderate',
            self::MODERATE_STRENUOUS => 'Moderate - Strenuous',
            self::STRENUOUS => 'Strenuous',
            self::EXTREME => 'Extreme',
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
            self::EASY => 'success',
            self::MODERATE => 'info',
            self::MODERATE_STRENUOUS => 'warning',
            self::STRENUOUS => 'danger',
            self::EXTREME => 'danger',
        };
    }
}
