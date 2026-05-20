<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Represents an authenticated user.
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'nationality',
        'passport_number',
        'date_of_birth',
        'gender',
        'is_active',
        'last_login_at',
        'last_login_ip',
        'referral_code',
        'referred_by',
        'loyalty_points',
        'affiliate_code',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Bookings created by the user.
     *
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Bookings guided by the user.
     *
     * @return HasMany
     */
    public function guidedBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'guide_id');
    }

    /**
     * Payments created by the user.
     *
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Reviews written by the user.
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Wishlisted tours for the user.
     *
     * @return BelongsToMany
     */
    public function wishlistedTours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'wishlists');
    }

    /**
     * Tours created by the user.
     *
     * @return HasMany
     */
    public function createdTours(): HasMany
    {
        return $this->hasMany(Tour::class, 'created_by');
    }

    /**
     * Affiliate applications reviewed by the user.
     *
     * @return HasMany
     */
    public function reviewedAffiliateApplications(): HasMany
    {
        return $this->hasMany(AffiliateApplication::class, 'reviewed_by');
    }

    /**
     * Inquiries assigned to the user.
     *
     * @return HasMany
     */
    public function assignedInquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'assigned_to');
    }

    /**
     * Coupons created by the user.
     *
     * @return HasMany
     */
    public function createdCoupons(): HasMany
    {
        return $this->hasMany(Coupon::class, 'created_by');
    }

    /**
     * Payments recorded by the user.
     *
     * @return HasMany
     */
    public function recordedPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'created_by');
    }

    /**
     * User who referred this user.
     *
     * @return BelongsTo
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(self::class, 'referred_by');
    }

    /**
     * Users referred by this user.
     *
     * @return HasMany
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(self::class, 'referred_by');
    }
}
