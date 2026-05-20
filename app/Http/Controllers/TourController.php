<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Destination;
use App\Models\Tour;
use App\Models\TourCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Handle public tour pages.
 */
class TourController extends Controller
{
    /**
     * Display the tours listing page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Tour::query()
            ->with(['destination', 'category'])
            ->where('is_active', true)
            ->where('is_published', true);

        if ($request->filled('q')) {
            $keyword = $request->string('q')->toString();
            $query->where(function ($sub) use ($keyword): void {
                $sub->where('title', 'like', "%{$keyword}%")
                    ->orWhere('short_description', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('destination')) {
            $query->where('destination_id', $request->integer('destination'));
        }

        if ($request->filled('region')) {
            $region = $request->string('region')->toString();
            $query->whereHas('destination', function ($sub) use ($region): void {
                $sub->where('region', $region);
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->integer('category'));
        }

        if ($request->filled('difficulty')) {
            $query->where('difficulty_level', $request->string('difficulty')->toString());
        }

        if ($request->filled('min_price')) {
            $query->where('base_price_adult', '>=', (int) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('base_price_adult', '<=', (int) $request->input('max_price'));
        }

        if ($request->filled('min_days')) {
            $query->where('duration_days', '>=', (int) $request->input('min_days'));
        }

        if ($request->filled('max_days')) {
            $query->where('duration_days', '<=', (int) $request->input('max_days'));
        }

        $tours = $query->orderByDesc('published_at')->paginate(9)->withQueryString();

        return view('tours.index', [
            'tours' => $tours,
            'destinations' => Destination::query()->where('is_active', true)->orderBy('name')->get(),
            'regions' => Destination::query()
                ->where('is_active', true)
                ->whereNotNull('region')
                ->where('region', '!=', '')
                ->select('region')
                ->distinct()
                ->orderBy('region')
                ->pluck('region'),
            'categories' => TourCategory::query()->where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    /**
     * Display a tour detail page.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        $tour = Tour::query()
            ->with([
                'destination',
                'category',
                'itineraries',
                'routePoints',
                'schedules',
                'faqs',
                'videoReviews',
            ])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $relatedTours = Tour::query()
            ->with('destination')
            ->where('id', '!=', $tour->id)
            ->where('is_active', true)
            ->where('is_published', true)
            ->when($tour->destination_id, function ($query) use ($tour): void {
                $query->where('destination_id', $tour->destination_id);
            })
            ->orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('tours.show', compact('tour', 'relatedTours'));
    }

    /**
     * Download a formatted itinerary PDF for a tour.
     *
     * @param string $slug
     * @return Response
     */
    public function downloadItinerary(string $slug): Response
    {
        $tour = Tour::query()
            ->with(['itineraries', 'destination'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->where('is_published', true)
            ->firstOrFail();

        $pdf = Pdf::loadView('tours.itinerary-pdf', [
            'tour' => $tour,
            'itineraries' => $tour->itineraries->sortBy('day_number')->values(),
        ])->setPaper('a4');

        return $pdf->download('itinerary-' . $tour->slug . '.pdf');
    }
}
