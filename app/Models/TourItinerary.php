<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a tour itinerary day.
 */
class TourItinerary extends Model
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
            'day_number' => 'integer',
            'meals_included' => 'array',
            'distance_km' => 'decimal:1',
            'walking_hours' => 'decimal:1',
            'max_altitude_meters' => 'integer',
            'min_altitude_meters' => 'integer',
            'sort_order' => 'integer',
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
