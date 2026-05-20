<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a customer inquiry.
 */
class Inquiry extends Model
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
            'travel_date' => 'date',
            'group_size' => 'integer',
            'replied_at' => 'datetime',
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

    /**
     * The assigned user relationship.
     *
     * @return BelongsTo
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
