<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Destination;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\Partner;
use App\Models\Review;
use App\Models\Slider;
use App\Models\TeamMember;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seed one record per resource for smoke testing.
 */
class SmokeTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command?->info('Creating smoke test records...');

        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@altivarotreks.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('Admin@1234'),
            ]
        );

        $destination = Destination::query()->firstOrCreate(
            ['slug' => 'smoke-test-nepal'],
            [
                'name' => 'Smoke Test Nepal',
                'continent' => 'Asia',
                'country' => 'Nepal',
                'description' => 'Smoke test destination description.',
                'short_description' => 'Short destination description.',
                'is_active' => true,
            ]
        );

        $category = TourCategory::query()->firstOrCreate(
            ['slug' => 'smoke-test-trekking'],
            [
                'name' => 'Smoke Test Trekking',
                'description' => 'Smoke test category.',
                'is_active' => true,
            ]
        );

        $tour = Tour::query()->firstOrCreate(
            ['slug' => 'smoke-test-tour'],
            [
                'destination_id' => $destination->id,
                'category_id' => $category->id,
                'created_by' => $admin->id,
                'title' => 'Smoke Test Tour',
                'short_description' => 'Short tour description.',
                'description' => 'Long tour description for smoke testing.',
                'duration_days' => 5,
                'duration_nights' => 4,
                'max_group_size' => 12,
                'base_price_adult' => 129900,
                'currency' => 'USD',
                'is_active' => true,
                'is_published' => true,
            ]
        );

        Coupon::query()->firstOrCreate(
            ['code' => 'SMOKE10'],
            [
                'description' => 'Smoke test coupon.',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'valid_from' => now()->subDay(),
                'valid_until' => now()->addMonth(),
                'is_active' => true,
                'created_by' => $admin->id,
            ]
        );

        Partner::query()->firstOrCreate(
            ['name' => 'Smoke Test Partner'],
            [
                'website_url' => 'https://example.com',
                'partner_type' => 'media',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        Slider::query()->firstOrCreate(
            ['title' => 'Smoke Test Slide'],
            [
                'subtitle' => 'Testing slide',
                'description' => 'Smoke test slider description.',
                'image' => 'sliders/smoke-test.jpg',
                'cta_text' => 'Explore',
                'cta_url' => '/tours',
                'overlay_opacity' => 0.4,
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        TeamMember::query()->firstOrCreate(
            ['name' => 'Smoke Test Guide'],
            [
                'role' => 'Guide',
                'bio' => 'Smoke test team member.',
                'sort_order' => 1,
                'is_published' => true,
            ]
        );

        Faq::query()->firstOrCreate(
            ['question' => 'What is the smoke test FAQ?'],
            [
                'answer' => 'This is a sample FAQ used for smoke testing.',
                'sort_order' => 1,
                'is_active' => true,
            ]
        );

        $booking = Booking::query()->firstOrCreate(
            ['booking_reference' => 'ALT-' . now()->format('Y') . '-SMOKE1'],
            [
                'tour_id' => $tour->id,
                'status' => 'confirmed',
                'payment_status' => 'deposit_paid',
                'booking_type' => 'solo',
                'adult_count' => 1,
                'child_count' => 0,
                'infant_count' => 0,
                'base_amount' => 129900,
                'addon_amount' => 0,
                'discount_amount' => 0,
                'tax_amount' => 0,
                'total_amount' => 129900,
                'deposit_amount' => 38970,
                'balance_amount' => 90930,
                'currency' => 'USD',
                'guest_name' => 'Smoke Guest',
                'guest_email' => 'smoke@example.com',
                'guest_phone' => '9800000000',
                'guest_nationality' => 'Nepalese',
                'special_requests' => 'None',
                'internal_notes' => 'Smoke test booking.',
            ]
        );

        Review::query()->firstOrCreate(
            [
                'booking_id' => $booking->id,
                'user_id' => $admin->id,
                'tour_id' => $tour->id,
            ],
            [
                'overall_rating' => 5,
                'title' => 'Smoke Test Review',
                'body' => 'Great tour for testing.',
                'is_verified' => true,
                'is_published' => true,
            ]
        );

        BlogPost::query()->firstOrCreate(
            ['slug' => 'smoke-test-post'],
            [
                'author_id' => $admin->id,
                'post_type' => 'blog',
                'title' => 'Smoke Test Blog Post',
                'excerpt' => 'Short smoke test excerpt.',
                'body' => 'Smoke test blog body content.',
                'is_published' => true,
                'published_at' => now(),
            ]
        );

        Inquiry::query()->firstOrCreate(
            ['name' => 'Smoke Test Inquiry'],
            [
                'tour_id' => $tour->id,
                'email' => 'inquiry@example.com',
                'phone' => '9800000001',
                'message' => 'Smoke test inquiry message.',
                'status' => 'new',
            ]
        );

        $this->command?->info('Smoke test records created.');
    }
}
