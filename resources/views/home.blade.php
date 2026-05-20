@extends('layouts.app')

@section('content')
<section class="relative bg-white">
    <div class="relative h-[78vh] min-h-[520px]">
        <div class="swiper hero-swiper h-full">
            <div class="swiper-wrapper">
                @forelse ($sliders as $slide)
                    <div class="swiper-slide relative">
                        @if ($slide->video_url)
                            <video class="h-full w-full object-cover" autoplay muted loop playsinline poster="{{ asset('storage/' . $slide->image) }}">
                                <source src="{{ $slide->video_url }}" type="video/mp4">
                            </video>
                        @else
                            <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->title }}" class="h-full w-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-slate-900" style="opacity: {{ $slide->overlay_opacity ?? 0.4 }}"></div>
                        <div class="absolute inset-0 flex items-center justify-center px-6">
                            <div class="max-w-3xl text-center text-white">
                                @if ($slide->subtitle)
                                    <p class="text-xs font-semibold uppercase tracking-[0.35em] text-white/80">{{ $slide->subtitle }}</p>
                                @endif
                                <h1 class="mt-4 text-4xl font-bold tracking-tight md:text-6xl">{{ $slide->title }}</h1>
                                @if ($slide->description)
                                    <p class="mt-4 text-base text-white/85 md:text-lg">{{ $slide->description }}</p>
                                @endif
                                @if ($slide->cta_text && $slide->cta_url)
                                    <a href="{{ $slide->cta_url }}" class="btn-orange mt-6 inline-flex">{{ $slide->cta_text }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide relative">
                        <div class="h-full w-full bg-gradient-to-br from-slate-200 via-slate-100 to-white"></div>
                        <div class="absolute inset-0 flex items-center justify-center px-6">
                            <div class="max-w-3xl text-center text-slate-900">
                                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Altivaro Treks</p>
                                <h1 class="mt-4 text-4xl font-bold tracking-tight md:text-6xl">Discover your path in the Himalayas</h1>
                                <p class="mt-4 text-base text-slate-600 md:text-lg">Premium Himalayan trekking crafted by local experts.</p>
                                <a href="{{ route('tours.index') }}" class="btn-orange mt-6 inline-flex">Explore Treks</a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="hero-pagination swiper-pagination"></div>
            <button type="button" class="hero-prev absolute left-6 top-1/2 z-10 hidden -translate-y-1/2 rounded-full bg-white/85 px-3 py-3 text-slate-900 shadow-lg lg:inline-flex">←</button>
            <button type="button" class="hero-next absolute right-6 top-1/2 z-10 hidden -translate-y-1/2 rounded-full bg-white/85 px-3 py-3 text-slate-900 shadow-lg lg:inline-flex">→</button>
        </div>

        <div class="absolute left-1/2 top-[calc(70%+70px)] z-20 w-[min(100%-2rem,980px)] -translate-x-1/2 -translate-y-1/2">
            <form action="{{ route('tours.index') }}" method="GET" class="flex w-full flex-col items-stretch gap-2 rounded-full bg-white p-3 shadow-2xl md:flex-row md:flex-nowrap md:items-center">
                <select name="destination" class="hero-search-input w-full py-2 md:flex-1 md:min-w-[160px]">
                    <option value="">Select Location</option>
                    @foreach ($destinations as $destination)
                        <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                    @endforeach
                </select>
                <select name="category" class="hero-search-input w-full py-2 md:flex-1 md:min-w-[160px]">
                    <option value="">Select Activity</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <input name="max_price" class="hero-search-input w-full py-2 md:flex-1 md:min-w-[140px]" placeholder="Select Budget">
                <input name="max_days" class="hero-search-input w-full py-2 md:flex-1 md:min-w-[140px]" placeholder="Select Duration">
                <button class="flex h-10 items-center justify-center rounded-full bg-orange px-5 text-sm font-semibold text-white shadow-md shadow-orange/40 md:shrink-0">Search</button>
            </form>
        </div>
    </div>
</section>

<section class="bg-white py-10">
    <div class="mx-auto max-w-7xl px-6">
        <div class="overflow-hidden rounded-3xl border border-slate-100 bg-slate-50">
            <div class="flex w-[200%] items-center gap-10 px-8 py-6 marquee-track">
                @forelse ($partners as $partner)
                    <a href="{{ $partner->website_url ?? '#' }}" target="_blank" class="flex items-center gap-3 text-sm font-semibold text-slate-600">
                        <span class="h-10 w-10 rounded-full bg-white shadow"></span>
                        {{ $partner->name }}
                    </a>
                @empty
                    <span class="text-sm text-slate-500">Add partners in the admin to populate this strip.</span>
                @endforelse
                @foreach ($partners as $partner)
                    <a href="{{ $partner->website_url ?? '#' }}" target="_blank" class="flex items-center gap-3 text-sm font-semibold text-slate-600">
                        <span class="h-10 w-10 rounded-full bg-white shadow"></span>
                        {{ $partner->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-16" id="best-sellers">
    <div class="flex flex-wrap items-end justify-between gap-6">
        <div>
            <p class="section-eyebrow">Best Sellers</p>
            <h2 class="text-3xl font-bold md:text-4xl">Top treks loved by global adventurers.</h2>
        </div>
        <a href="{{ route('tours.index') }}" class="text-sm font-semibold uppercase tracking-[0.2em] text-navy">View All Trips →</a>
    </div>
    <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($bestSellerTours as $tour)
            <article class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-1" data-aos="fade-up">
                <div class="relative overflow-hidden rounded-2xl bg-slate-100">
                    <div class="absolute left-4 top-4 rounded-full bg-orange px-3 py-1 text-xs font-semibold text-white">Best Seller</div>
                    @php
                        $thumbMedia = $tour->getFirstMedia('thumbnail');
                        $thumbUrl = $thumbMedia
                            ? ($thumbMedia->hasGeneratedConversion('thumb') ? $thumbMedia->getUrl('thumb') : $thumbMedia->getUrl())
                            : null;
                    @endphp
                    @if ($thumbUrl)
                        <img src="{{ $thumbUrl }}" alt="{{ $tour->title }}" class="aspect-[4/3] w-full object-cover">
                    @else
                        <div class="aspect-[4/3] bg-gradient-to-br from-slate-200 to-slate-50"></div>
                    @endif
                </div>
                <div class="mt-4 space-y-2">
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                        {{ $tour->duration_days }} Days · {{ $tour->destination?->name ?? 'Nepal' }}
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">{{ $tour->title }}</h3>
                    <div class="flex items-baseline gap-2 text-sm">
                        @if ($tour->original_price_adult)
                            <span class="text-slate-400 line-through">{{ $tour->getStrikethroughPriceAttribute() }}</span>
                        @endif
                        <span class="text-lg font-semibold text-orange">{{ $tour->getFormattedPriceAttribute() }}</span>
                    </div>
                </div>
            </article>
        @empty
            <p class="text-slate-500">Add best-seller tours in the admin to show cards here.</p>
        @endforelse
    </div>
</section>

<section class="bg-white py-16" id="featured">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="section-eyebrow">Featured Travel</p>
                <h2 class="text-3xl font-bold md:text-4xl">Signature experiences designed for bold explorers.</h2>
            </div>
            <a href="{{ route('tours.index') }}" class="text-sm font-semibold uppercase tracking-[0.2em] text-orange">Discover More →</a>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-2">
            @forelse ($featuredTours as $tour)
                <article class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="flex flex-col gap-6 lg:flex-row">
                        @php
                            $thumbMedia = $tour->getFirstMedia('thumbnail');
                            $thumbUrl = $thumbMedia
                                ? ($thumbMedia->hasGeneratedConversion('web') ? $thumbMedia->getUrl('web') : $thumbMedia->getUrl())
                                : null;
                        @endphp
                        @if ($thumbUrl)
                            <img src="{{ $thumbUrl }}" alt="{{ $tour->title }}" class="aspect-[4/3] w-full rounded-2xl object-cover lg:w-1/2">
                        @else
                            <div class="aspect-[4/3] w-full rounded-2xl bg-gradient-to-br from-slate-200 to-slate-50 lg:w-1/2"></div>
                        @endif
                        <div class="flex-1 space-y-3">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Featured Journey</p>
                            <h3 class="text-2xl font-semibold text-slate-900">{{ $tour->title }}</h3>
                            <p class="text-sm text-slate-600">{{ $tour->short_description }}</p>
                            <div class="text-sm text-slate-500">{{ $tour->duration_days }} Days · {{ $tour->destination?->name ?? 'Nepal' }}</div>
                            <a href="{{ route('tours.show', $tour->slug) }}" class="btn-orange">View Trek</a>
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-slate-500">Feature tours by enabling the featured toggle in the admin.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-16" id="popular">
    <div class="flex flex-wrap items-end justify-between gap-6">
        <div>
            <p class="section-eyebrow">Popular Travel</p>
            <h2 class="text-3xl font-bold md:text-4xl">Fan favorites for first-timers and veterans.</h2>
        </div>
    </div>
    <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($popularTours as $tour)
            <article class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm" data-aos="fade-up">
                @php
                    $thumbMedia = $tour->getFirstMedia('thumbnail');
                    $thumbUrl = $thumbMedia
                        ? ($thumbMedia->hasGeneratedConversion('thumb') ? $thumbMedia->getUrl('thumb') : $thumbMedia->getUrl())
                        : null;
                @endphp
                @if ($thumbUrl)
                    <img src="{{ $thumbUrl }}" alt="{{ $tour->title }}" class="aspect-[4/3] w-full rounded-2xl object-cover">
                @else
                    <div class="aspect-[4/3] rounded-2xl bg-gradient-to-br from-slate-200 to-slate-50"></div>
                @endif
                <div class="mt-4 space-y-2">
                    <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">
                        {{ $tour->duration_days }} Days · {{ $tour->destination?->name ?? 'Nepal' }}
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">{{ $tour->title }}</h3>
                    <p class="text-sm text-slate-600">{{ $tour->short_description }}</p>
                </div>
            </article>
        @empty
            <p class="text-slate-500">Popular tours will appear once bookings and ratings grow.</p>
        @endforelse
    </div>
</section>

<section class="bg-white py-16" id="regions">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="section-eyebrow">Travel by Region</p>
                <h2 class="text-3xl font-bold md:text-4xl">Choose your Himalayan region.</h2>
            </div>
        </div>
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($regionStats as $region)
                <a href="{{ route('tours.index', ['region' => $region['region']]) }}" class="group rounded-3xl border border-slate-100 bg-slate-50 p-6 transition hover:-translate-y-1">
                    <div class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-400">Region</div>
                    <h3 class="mt-3 text-xl font-semibold text-slate-900">{{ $region['region'] }}</h3>
                    <p class="mt-2 text-sm text-slate-600">{{ $region['tour_count'] }} treks · {{ $region['destination_count'] }} destinations</p>
                    <span class="mt-4 inline-flex items-center text-sm font-semibold text-orange">Browse Treks →</span>
                </a>
            @empty
                <p class="text-slate-500">Add destination regions in the admin to show this section.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="bg-white py-16" id="about">
    <div class="mx-auto grid max-w-7xl gap-10 px-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div>
            <p class="section-eyebrow">About Us</p>
            <h2 class="text-3xl font-bold md:text-4xl">Local teams. Global standards. Himalayan heart.</h2>
            <p class="mt-4 text-slate-600">{{ setting('general.tagline', 'Connecting trekkers to the Himalayas with safety-first, community-driven journeys.') }}</p>
            <p class="mt-4 text-slate-600">We craft immersive routes across Nepal, balancing adventure with cultural depth, flexible logistics, and locally trained guides.</p>
            <a href="{{ route('about') }}" class="btn-outline-white mt-6">Learn More About Us</a>
        </div>
        <div class="grid gap-6">
            @php
                $stats = [
                    ['40,000+', 'Happy Trekkers'],
                    ['1,600+', 'TripAdvisor Reviews'],
                    ['15+', 'Years Experience'],
                    ['98%', 'Safety Record'],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="rounded-2xl border border-slate-200 bg-white p-6">
                    <div class="text-3xl font-bold text-slate-900">{{ $stat[0] }}</div>
                    <p class="mt-2 text-sm uppercase tracking-[0.2em] text-slate-500">{{ $stat[1] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-navy py-16" id="testimonials">
    <div class="mx-auto max-w-7xl px-6 text-white">
        <div class="grid gap-10 md:grid-cols-[1fr_1.2fr]">
            <div>
                <p class="section-eyebrow text-orange">Testimonials</p>
                <h2 class="text-3xl font-bold text-white md:text-4xl">Trusted by trekkers across the globe.</h2>
                <p class="mt-4 text-white/80">From EBC to Annapurna, our travelers share the same story: thoughtful planning and unforgettable mountains.</p>
            </div>
            <div class="space-y-4">
                @forelse ($testimonials as $testimonial)
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-5">
                        <p class="text-sm text-white/85">“{{ $testimonial->quote }}”</p>
                        <div class="mt-3 text-sm font-semibold text-white">{{ $testimonial->name ?? 'Happy Trekker' }}</div>
                    </div>
                @empty
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-5 text-white/80">Add testimonials in the admin to populate this section.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-16" id="video-reviews">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="section-eyebrow">Video Reviews</p>
                <h2 class="text-3xl font-bold md:text-4xl">Hear it from our trekkers.</h2>
            </div>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($videoReviews as $review)
                @php
                    $videoId = $review->youtube_video_id ?? null;
                    if (! $videoId && $review->youtube_url) {
                        preg_match('~(?:youtu\\.be/|youtube\\.com/(?:watch\\?v=|embed/|v/|shorts/))([^&?/#]+)~', $review->youtube_url, $matches);
                        $videoId = $matches[1] ?? null;
                    }
                    $thumbnail = $review->thumbnail_url ?: ($videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : null);
                @endphp
                <a href="{{ $review->youtube_url }}" target="_blank" class="group overflow-hidden rounded-3xl border border-slate-100 bg-white shadow-sm">
                    <div class="relative aspect-[16/10] bg-slate-100">
                        @if ($thumbnail)
                            <img src="{{ $thumbnail }}" alt="{{ $review->title ?? 'Video review' }}" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full bg-gradient-to-br from-slate-200 to-slate-50"></div>
                        @endif
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-white/90 text-orange">▶</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $review->tour?->title ?? 'Tour Review' }}</p>
                        <h3 class="mt-2 text-lg font-semibold text-slate-900">{{ $review->title ?? 'Traveler Story' }}</h3>
                        <p class="mt-1 text-sm text-slate-600">{{ $review->reviewer_name ?? 'Altivaro Trekker' }}</p>
                    </div>
                </a>
            @empty
                <p class="text-slate-500">Add video reviews to tours to show them here.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-16" id="travel-guides">
    <div class="flex flex-wrap items-end justify-between gap-6">
        <div>
            <p class="section-eyebrow">Travel Guides</p>
            <h2 class="text-3xl font-bold md:text-4xl">Practical insights for high-altitude journeys.</h2>
        </div>
        <a href="{{ route('blog.guides') }}" class="text-sm font-semibold uppercase tracking-[0.2em] text-navy">Explore Guides →</a>
    </div>
    <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($travelGuides as $post)
            <article class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                <div class="aspect-[4/3] rounded-2xl bg-slate-100"></div>
                <div class="mt-4 space-y-2">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Travel Guide</span>
                    <h3 class="text-lg font-semibold text-slate-900">{{ $post->title }}</h3>
                    <p class="text-sm text-slate-600">{{ $post->excerpt }}</p>
                </div>
            </article>
        @empty
            <p class="text-slate-500">Publish travel guides to show them here.</p>
        @endforelse
    </div>
</section>

<section class="bg-white py-16" id="latest-blogs">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="section-eyebrow">Latest Blog</p>
                <h2 class="text-3xl font-bold md:text-4xl">Stories, tips, and Himalayan inspiration.</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="text-sm font-semibold uppercase tracking-[0.2em] text-navy">Explore Articles →</a>
        </div>
        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($latestPosts as $post)
                <article class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="aspect-[4/3] rounded-2xl bg-slate-100"></div>
                    <div class="mt-4 space-y-2">
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $post->post_type === 'travel_guide' ? 'Travel Guide' : 'Blog' }}</span>
                        <h3 class="text-lg font-semibold text-slate-900">{{ $post->title }}</h3>
                        <p class="text-sm text-slate-600">{{ $post->excerpt }}</p>
                    </div>
                </article>
            @empty
                <p class="text-slate-500">Publish blog posts to show them here.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
