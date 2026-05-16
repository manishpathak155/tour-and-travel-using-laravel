<?php

namespace App\Models;

use App\Enums\DifficultyLevel;
use App\Enums\TourType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * Represents a trekking tour.
 */
class Tour extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Get the slug options for the model.
     *
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the model attribute casts.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'highlights' => 'array',
            'inclusions' => 'array',
            'exclusions' => 'array',
            'essential_info' => 'array',
            'what_to_bring' => 'array',
            'gear_list' => 'array',
            'languages_offered' => 'array',
            'base_price_adult' => 'integer',
            'original_price_adult' => 'integer',
            'base_price_child' => 'integer',
            'base_price_infant' => 'integer',
            'private_tour_price' => 'integer',
            'average_rating' => 'decimal:2',
            'difficulty_level' => DifficultyLevel::class,
            'tour_type' => TourType::class,
            'is_best_seller' => 'boolean',
            'is_guaranteed_departure' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /**
     * Register media collections for the tour.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnail')->singleFile();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('brochure')->singleFile();
    }

    /**
     * Register media conversions for the tour.
     *
     * @param Media|null $media
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Crop, 400, 300)
            ->performOnCollections('thumbnail');

        $this
            ->addMediaConversion('medium')
            ->fit(Fit::Crop, 800, 600)
            ->performOnCollections('thumbnail');

        $this
            ->addMediaConversion('og')
            ->fit(Fit::Crop, 1200, 630)
            ->performOnCollections('thumbnail');

        $this
            ->addMediaConversion('web')
            ->fit(Fit::Crop, 1200, 800)
            ->performOnCollections('gallery');
    }

    /**
     * Destination relationship.
     *
     * @return BelongsTo
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Category relationship.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TourCategory::class, 'category_id');
    }

    /**
     * User who created the tour.
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Itinerary entries.
     *
     * @return HasMany
     */
    public function itineraries(): HasMany
    {
        return $this->hasMany(TourItinerary::class)->orderBy('day_number');
    }

    /**
     * Schedule dates.
     *
     * @return HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(TourSchedule::class)->orderBy('departure_date');
    }

    /**
     * Add-ons for the tour.
     *
     * @return HasMany
     */
    public function addons(): HasMany
    {
        return $this->hasMany(TourAddon::class)->orderBy('sort_order');
    }

    /**
     * Video reviews.
     *
     * @return HasMany
     */
    public function videoReviews(): HasMany
    {
        return $this->hasMany(TourVideoReview::class)->orderBy('sort_order');
    }

    /**
     * Route map points.
     *
     * @return HasMany
     */
    public function routePoints(): HasMany
    {
        return $this->hasMany(TourRoutePoint::class)->orderBy('day_number');
    }

    /**
     * Bookings for the tour.
     *
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Reviews for the tour.
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * FAQs for the tour.
     *
     * @return HasMany
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class);
    }

    /**
     * Users who wishlisted the tour.
     *
     * @return BelongsToMany
     */
    public function wishlistedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists');
    }

    /**
     * Scope active tours.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope published tours.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope featured tours.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope best seller tours.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeBestSeller(Builder $query): Builder
    {
        return $query->where('is_best_seller', true);
    }

    /**
     * Scope guaranteed departure tours.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeGuaranteedDeparture(Builder $query): Builder
    {
        return $query->where('is_guaranteed_departure', true);
    }

    /**
     * Scope by difficulty.
     *
     * @param Builder $query
     * @param DifficultyLevel $difficulty
     * @return Builder
     */
    public function scopeByDifficulty(Builder $query, DifficultyLevel $difficulty): Builder
    {
        return $query->where('difficulty_level', $difficulty->value);
    }

    /**
     * Scope by category.
     *
     * @param Builder $query
     * @param int $categoryId
     * @return Builder
     */
    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope by destination.
     *
     * @param Builder $query
     * @param int $destinationId
     * @return Builder
     */
    public function scopeByDestination(Builder $query, int $destinationId): Builder
    {
        return $query->where('destination_id', $destinationId);
    }

    /**
     * Scope by price range.
     *
     * @param Builder $query
     * @param int $min
     * @param int $max
     * @return Builder
     */
    public function scopePriceRange(Builder $query, int $min, int $max): Builder
    {
        return $query
            ->where('base_price_adult', '>=', $min)
            ->where('base_price_adult', '<=', $max);
    }

    /**
     * Scope by duration range.
     *
     * @param Builder $query
     * @param int $minDays
     * @param int $maxDays
     * @return Builder
     */
    public function scopeDurationRange(Builder $query, int $minDays, int $maxDays): Builder
    {
        return $query
            ->where('duration_days', '>=', $minDays)
            ->where('duration_days', '<=', $maxDays);
    }

    /**
     * Get the formatted base price.
     *
     * @return string
     */
    public function getFormattedPriceAttribute(): string
    {
        return $this->formatMoney($this->base_price_adult ?? 0);
    }

    /**
     * Get the formatted original price.
     *
     * @return string|null
     */
    public function getStrikethroughPriceAttribute(): ?string
    {
        if (! $this->original_price_adult) {
            return null;
        }

        return $this->formatMoney($this->original_price_adult);
    }

    /**
     * Get the available seats for a specific date.
     *
     * @param Carbon $date
     * @return int
     */
    public function getAvailableSeatsForDate(Carbon $date): int
    {
        $schedule = $this->schedules()
            ->whereDate('departure_date', $date->toDateString())
            ->first();

        if (! $schedule) {
            return 0;
        }

        if (in_array($schedule->status, ['full', 'closed', 'cancelled'], true)) {
            return 0;
        }

        return max(0, $schedule->total_seats - $schedule->booked_seats);
    }

    /**
     * Determine if the tour is available on a date.
     *
     * @param Carbon $date
     * @return bool
     */
    public function isAvailableOn(Carbon $date): bool
    {
        return $this->getAvailableSeatsForDate($date) > 0;
    }

    /**
     * Calculate pricing for a party size.
     *
     * @param int $adults
     * @param int $children
     * @param int $infants
     * @return array<string, mixed>
     */
    public function calculatePrice(int $adults, int $children, int $infants): array
    {
        $adultTotal = $adults * ($this->base_price_adult ?? 0);
        $childTotal = $children * ($this->base_price_child ?? 0);
        $infantTotal = $infants * ($this->base_price_infant ?? 0);

        $base = $adultTotal + $childTotal + $infantTotal;
        $addons = 0;
        $discount = 0;
        $tax = 0;
        $total = $base + $addons - $discount + $tax;
        $deposit = (int) round($total * (($this->deposit_percentage ?? 0) / 100));

        return [
            'base' => $base,
            'addons' => $addons,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
            'deposit' => $deposit,
            'breakdown' => [
                'adults' => $adultTotal,
                'children' => $childTotal,
                'infants' => $infantTotal,
            ],
        ];
    }

    /**
     * Build altitude profile data for charts.
     *
     * @return array<string, array<int, mixed>>
     */
    public function getAltitudeProfileData(): array
    {
        $points = $this->routePoints()->orderBy('day_number')->get();

        return [
            'labels' => $points->map(fn ($point) => 'Day ' . $point->day_number)->toArray(),
            'altitudes' => $points->map(fn ($point) => $point->altitude_meters)->toArray(),
        ];
    }

    /**
     * Get ordered route map points.
     *
     * @return Collection<int, TourRoutePoint>
     */
    public function getRouteMapPoints(): Collection
    {
        return $this->routePoints()
            ->orderBy('day_number')
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Extract a YouTube video ID from a URL.
     *
     * @param string $url
     * @return string
     */
    public function extractYoutubeId(string $url): string
    {
        $pattern = '%(?:youtube(?:-nocookie)?\\.com/(?:[^/\\n\\s]+\\/\\S+\\/|(?:v|e(?:mbed)?)\\/|\\S*?[?&]v=)|youtu\\.be/)([a-zA-Z0-9_-]{11})%';

        if (preg_match($pattern, $url, $matches) === 1) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Format a monetary value from minor units.
     *
     * @param int $amount
     * @return string
     */
    protected function formatMoney(int $amount): string
    {
        $currency = $this->currency ?? 'USD';
        $prefix = $currency === 'USD' ? 'US$' : $currency;
        $formatted = number_format($amount / 100, 0);

        return $prefix . ' ' . $formatted;
    }
}
