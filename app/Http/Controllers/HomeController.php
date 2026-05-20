<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Destination;
use App\Models\Partner;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\TourVideoReview;
use Illuminate\Contracts\View\View;

/**
 * Handle homepage requests.
 */
class HomeController extends Controller
{
    /**
     * Display the homepage.
     *
     * @return View
     */
    public function index(): View
    {
        $destinations = Destination::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $categories = TourCategory::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        $regions = Destination::query()
            ->where('is_active', true)
            ->whereNotNull('region')
            ->where('region', '!=', '')
            ->select('region')
            ->distinct()
            ->orderBy('region')
            ->pluck('region');

        $regionStats = Destination::query()
            ->where('is_active', true)
            ->whereNotNull('region')
            ->where('region', '!=', '')
            ->withCount(['tours' => function ($query): void {
                $query->where('is_active', true)->where('is_published', true);
            }])
            ->get()
            ->groupBy('region')
            ->map(function ($items, $region): array {
                return [
                    'region' => $region,
                    'tour_count' => $items->sum('tours_count'),
                    'destination_count' => $items->count(),
                ];
            })
            ->values();

        $sliders = Slider::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $bestSellerTours = Tour::query()
            ->with('destination')
            ->where('is_best_seller', true)
            ->where('is_active', true)
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        $featuredTours = Tour::query()
            ->with('destination')
            ->where('is_featured', true)
            ->where('is_active', true)
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->limit(2)
            ->get();

        $popularTours = Tour::query()
            ->with('destination')
            ->where('is_active', true)
            ->where('is_published', true)
            ->orderByDesc('total_bookings')
            ->orderByDesc('average_rating')
            ->limit(6)
            ->get();

        $partners = Partner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $testimonials = Testimonial::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $latestPosts = BlogPost::query()
            ->with('author')
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $travelGuides = BlogPost::query()
            ->with('author')
            ->where('is_published', true)
            ->where('post_type', 'travel_guide')
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        $videoReviews = TourVideoReview::query()
            ->with('tour')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        return view('home', compact(
            'bestSellerTours',
            'featuredTours',
            'popularTours',
            'partners',
            'testimonials',
            'latestPosts',
            'travelGuides',
            'videoReviews',
            'destinations',
            'categories',
            'regions',
            'regionStats',
            'sliders'
        ));
    }
}
