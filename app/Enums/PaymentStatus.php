<?php

namespace App\Enums;

/**
 * Payment status values.
 */
enum PaymentStatus: string
{
    case UNPAID = 'unpaid';
    case DEPOSIT_PAID = 'deposit_paid';
    case PARTIALLY_PAID = 'partially_paid';
    case FULLY_PAID = 'fully_paid';
    case REFUNDED = 'refunded';
    case FAILED = 'failed';

    /**
     * Get the human-readable label.
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::UNPAID => 'Unpaid',
            self::DEPOSIT_PAID => 'Deposit Paid',
            self::PARTIALLY_PAID => 'Partially Paid',
            self::FULLY_PAID => 'Fully Paid',
            self::REFUNDED => 'Refunded',
            self::FAILED => 'Failed',
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
            self::UNPAID => 'danger',
            self::DEPOSIT_PAID => 'warning',
            self::PARTIALLY_PAID => 'warning',
            self::FULLY_PAID => 'success',
            self::REFUNDED => 'gray',
            self::FAILED => 'danger',
        };
    }
}
