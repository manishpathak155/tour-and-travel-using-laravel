<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Represents a booking for a tour.
 */
class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

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
            'status' => BookingStatus::class,
            'payment_status' => PaymentStatus::class,
            'adult_count' => 'integer',
            'child_count' => 'integer',
            'infant_count' => 'integer',
            'base_amount' => 'integer',
            'addon_amount' => 'integer',
            'discount_amount' => 'integer',
            'tax_amount' => 'integer',
            'total_amount' => 'integer',
            'deposit_amount' => 'integer',
            'balance_amount' => 'integer',
            'departure_date' => 'date',
            'return_date' => 'date',
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
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
     * The schedule relationship.
     *
     * @return BelongsTo
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(TourSchedule::class, 'schedule_id');
    }

    /**
     * The booking user relationship.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The guide relationship.
     *
     * @return BelongsTo
     */
    public function guide(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guide_id');
    }

    /**
     * The applied coupon relationship.
     *
     * @return BelongsTo
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Booking travelers.
     *
     * @return HasMany
     */
    public function travelers(): HasMany
    {
        return $this->hasMany(BookingTraveler::class);
    }

    /**
     * Booking payments.
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Booking add-ons.
     *
     * @return BelongsToMany
     */
    public function addons(): BelongsToMany
    {
        return $this->belongsToMany(TourAddon::class, 'booking_addon')
            ->withPivot(['quantity', 'price_at_booking'])
            ->withTimestamps();
    }

    /**
     * Generate booking reference when creating.
     */
    protected static function booted(): void
    {
        static::creating(function (Booking $booking): void {
            if ($booking->booking_reference) {
                return;
            }

            $booking->booking_reference = 'ALT-' . now()->format('Y') . '-' . strtoupper(Str::random(6));
        });
    }

    /**
     * Calculate the remaining balance.
     *
     * @return int
     */
    public function getBalanceDueAttribute(): int
    {
        return max(0, (int) ($this->balance_amount ?? 0));
    }

    /**
     * Determine if the booking is fully paid.
     *
     * @return bool
     */
    public function isFullyPaid(): bool
    {
        return $this->payment_status === PaymentStatus::FULLY_PAID;
    }

    /**
     * Determine if the booking can be cancelled.
     *
     * @return bool
     */
    public function canBeCancelled(): bool
    {
        if (! $this->departure_date) {
            return true;
        }

        return $this->departure_date->isFuture();
    }

    /**
     * Days remaining to departure.
     *
     * @return int
     */
    public function getDaysToDepartureAttribute(): int
    {
        if (! $this->departure_date) {
            return 0;
        }

        return Carbon::now()->diffInDays($this->departure_date, false);
    }

    /**
     * Generate a voucher PDF and return the file path.
     *
     * @return string
     */
    public function generateVoucherPDF(): string
    {
        if (! class_exists(\App\Services\BookingService::class)) {
            return '';
        }

        return app(\App\Services\BookingService::class)->generateVoucherPDF($this);
    }

    /**
     * Queue a booking confirmation email.
     */
    public function sendConfirmationEmail(): void
    {
        if (! class_exists(\App\Services\NotificationService::class)) {
            return;
        }

        app(\App\Services\NotificationService::class)->bookingConfirmed($this);
    }
}
