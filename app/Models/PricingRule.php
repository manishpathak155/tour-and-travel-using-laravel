<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a pricing rule for a tour.
 */
class PricingRule extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Get the model attribute casts.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'discount_value' => 'decimal:2',
            'min_group_size' => 'integer',
            'advance_booking_days' => 'integer',
            'days_before_departure' => 'integer',
            'valid_from' => 'date',
            'valid_until' => 'date',
            'max_uses' => 'integer',
            'current_uses' => 'integer',
            'is_active' => 'boolean',
            'priority' => 'integer',
        ];
    }

    /**
     * The tour relationship.
     *
     * @return BelongsTo
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
