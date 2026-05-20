@extends('layouts.app')

@section('content')
@php
    $galleryItems = $tour->getMedia('gallery');
    $tourTitle = $tour->title;

    if ($galleryItems->isEmpty() && $tour->getFirstMedia('thumbnail')) {
        $galleryItems = collect([$tour->getFirstMedia('thumbnail')]);
    }

    $galleryData = $galleryItems->map(function ($media) use ($tourTitle): array {
        $url = $media->hasGeneratedConversion('web') ? $media->getUrl('web') : $media->getUrl();
        $thumbUrl = $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $url;

        return [
            'url' => $url,
            'thumb' => $thumbUrl,
            'alt' => $tourTitle,
        ];
    })->values();

    $mainMedia = $galleryData->first();
    $sidebarMedia = $galleryData->slice(1, 4)->values();
    $highlights = collect($tour->highlights ?? [])->map(fn ($item) => is_array($item) ? ($item['value'] ?? null) : $item)->filter()->values();
    $scheduleDates = $tour->schedules->sortBy('departure_date')->values();
@endphp

<section class="bg-white pb-10">
    <div class="mx-auto max-w-7xl px-6 pt-8">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 md:text-4xl">{{ $tour->title }}</h1>
                <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-slate-500">
                    <span>{{ $tour->category?->name ?? 'Trek' }}</span>
                    <span>•</span>
                    <span>{{ $tour->destination?->name ?? 'Nepal' }}</span>
                    <span>•</span>
                    <span>{{ $tour->duration_days }}D / {{ $tour->duration_nights }}N</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button type="button" data-share-tour class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-orange hover:text-orange">Share</button>
                <button type="button" data-like-tour class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-orange hover:text-orange">
                    <span data-like-icon>♡</span>
                    <span data-like-label>Like</span>
                </button>
            </div>
        </div>

        <p class="mt-4 max-w-3xl text-sm text-slate-600 md:text-base">{{ $tour->short_description }}</p>

        <div class="mt-6 grid gap-3 lg:grid-cols-[1.6fr_1fr]">
            <div class="overflow-hidden rounded-2xl bg-slate-100">
                @if ($mainMedia)
                    <img src="{{ $mainMedia['url'] }}" alt="{{ $tour->title }}" class="h-72 w-full object-cover md:h-96">
                @else
                    <div class="h-72 w-full bg-linear-to-br from-slate-200 to-slate-50 md:h-96"></div>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-3 lg:grid-rows-2">
                @for ($i = 0; $i < 4; $i++)
                    @php $image = $sidebarMedia->get($i); @endphp
                    <div class="overflow-hidden rounded-2xl bg-slate-100">
                        @if ($image)
                            <img src="{{ $image['thumb'] }}" alt="{{ $tour->title }}" class="h-28 w-full object-cover md:h-44 lg:h-full">
                        @else
                            <div class="h-28 w-full bg-linear-to-br from-slate-200 to-slate-50 md:h-44 lg:h-full"></div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        <div class="mt-5 flex justify-center">
            <button type="button" data-gallery-open class="btn-orange">Show all photos</button>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 pb-14">
    <div class="sticky top-16 z-20 border-b border-slate-200 bg-white">
        <div class="flex flex-wrap gap-6 py-3 text-sm font-semibold text-slate-600">
            <button type="button" data-tour-tab="overview" class="tour-tab-btn">Overview</button>
            <button type="button" data-tour-tab="location" class="tour-tab-btn">Location</button>
            <button type="button" data-tour-tab="itinerary" class="tour-tab-btn">Itinerary</button>
            <button type="button" data-tour-tab="reviews" class="tour-tab-btn">Reviews</button>
        </div>
    </div>

    <div class="mt-8 grid gap-8 lg:grid-cols-[1.45fr_0.9fr]">
        <div class="space-y-8">
            <section data-tour-panel="overview" class="space-y-8">
                <div>
                    <h2 class="text-2xl font-semibold">Trip Facts</h2>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-lg bg-slate-100 px-4 py-3 text-sm"><span class="font-semibold">Starts at:</span> {{ $tour->starts_city ?? 'N/A' }}</div>
                        <div class="rounded-lg bg-slate-100 px-4 py-3 text-sm"><span class="font-semibold">Ends at:</span> {{ $tour->ends_city ?? 'N/A' }}</div>
                        <div class="rounded-lg bg-slate-100 px-4 py-3 text-sm"><span class="font-semibold">Trek Region:</span> {{ $tour->destination?->region ?? ($tour->destination?->name ?? 'N/A') }}</div>
                        <div class="rounded-lg bg-slate-100 px-4 py-3 text-sm"><span class="font-semibold">Transport:</span> {{ $tour->transport ?? 'Tourist/Local vehicle' }}</div>
                        <div class="rounded-lg bg-slate-100 px-4 py-3 text-sm"><span class="font-semibold">Duration:</span> {{ $tour->duration_days }} Days</div>
                        <div class="rounded-lg bg-slate-100 px-4 py-3 text-sm"><span class="font-semibold">Trip Grade:</span> {{ $tour->trip_grade ?? ($tour->difficulty_level?->label() ?? 'N/A') }}</div>
                        <div class="rounded-lg bg-slate-100 px-4 py-3 text-sm"><span class="font-semibold">Max Altitude:</span> {{ $tour->max_altitude_meters ?? 'N/A' }} meters</div>
                        <div class="rounded-lg bg-slate-100 px-4 py-3 text-sm"><span class="font-semibold">Accommodation:</span> Lodge/Tea House</div>
                    </div>
                </div>

                @if ($highlights->isNotEmpty())
                    <div>
                        <h2 class="text-2xl font-semibold">Trip Highlights</h2>
                        <ul class="mt-4 space-y-2 text-sm text-slate-700">
                            @foreach ($highlights as $highlight)
                                <li>• {{ $highlight }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div>
                    <h2 class="text-2xl font-semibold">Overview</h2>
                    <div class="prose prose-slate mt-4 max-w-none">{!! $tour->description !!}</div>
                </div>
            </section>

            <section data-tour-panel="location" class="space-y-6 hidden">
                <h2 class="text-2xl font-semibold">Location</h2>
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="h-60 rounded-xl bg-slate-100"></div>
                    <p class="mt-3 text-sm text-slate-500">Route map and coordinates appear here based on route points.</p>
                    @if ($tour->routePoints->isNotEmpty())
                        <div class="mt-4 space-y-2">
                            @foreach ($tour->routePoints as $point)
                                <div class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 text-sm">
                                    <span>Day {{ $point->day_number }} - {{ $point->place_name }}</span>
                                    <span class="text-slate-500">{{ $point->altitude_meters ? $point->altitude_meters . ' m' : 'N/A' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <section data-tour-panel="itinerary" class="space-y-6 hidden">
                <h2 class="text-2xl font-semibold">Itinerary</h2>
                @if ($tour->itineraries->isNotEmpty())
                    <div class="space-y-3">
                        @foreach ($tour->itineraries as $day)
                            <details class="rounded-xl border border-slate-200 bg-white p-4" @open($loop->first)>
                                <summary class="cursor-pointer text-sm font-semibold">Day {{ $day->day_number }} - {{ $day->title }}</summary>
                                <div class="prose prose-slate mt-3 max-w-none text-sm">{!! $day->description !!}</div>
                            </details>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-slate-500">No itinerary details available yet.</p>
                @endif

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <h3 class="font-semibold">Difficulty Level</h3>
                    <p class="mt-2 text-sm text-slate-700">{{ $tour->difficulty_level?->label() ?? 'N/A' }}</p>
                    @if ($tour->private_tour_price)
                        <p class="mt-4 text-sm text-slate-700">Group / Private Departure: {{ $tour->currency }} {{ number_format((float) $tour->private_tour_price, 2) }}</p>
                    @endif
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <h3 class="font-semibold">Download Itinerary</h3>
                        <a href="{{ route('tours.itinerary', $tour->slug) }}" class="btn-orange">PDF</a>
                    </div>
                    <p class="mt-2 text-sm text-slate-500">Download a properly formatted PDF copy of this itinerary.</p>
                </div>
            </section>

            <section data-tour-panel="reviews" class="space-y-4 hidden" id="reviews-panel">
                <h2 class="text-2xl font-semibold">Reviews</h2>
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="rounded-xl bg-slate-100 px-4 py-3 text-sm"><span class="font-semibold">TripAdvisor:</span> {{ $tour->tripadvisor_review_count ?? 0 }} reviews</div>
                    <div class="rounded-xl bg-slate-100 px-4 py-3 text-sm"><span class="font-semibold">Google:</span> {{ $tour->google_review_count ?? 0 }} reviews</div>
                    <div class="rounded-xl bg-slate-100 px-4 py-3 text-sm"><span class="font-semibold">Trustpilot:</span> {{ $tour->trustpilot_review_count ?? 0 }} reviews</div>
                </div>

                @if ($tour->videoReviews->isNotEmpty())
                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach ($tour->videoReviews as $review)
                            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                                <p class="font-semibold">{{ $review->title ?? 'Video Review' }}</p>
                                @if ($review->reviewer_name)
                                    <p class="text-xs text-slate-500">{{ $review->reviewer_name }}</p>
                                @endif
                                @if ($review->youtube_url)
                                    <a href="{{ $review->youtube_url }}" target="_blank" rel="noopener" class="mt-2 inline-block text-sm font-semibold text-orange">Watch video</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        <aside>
            <div class="sticky top-24 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm" id="booking-card"
                data-adult="{{ (int) ($tour->base_price_adult ?? 0) }}"
                data-child="{{ (int) ($tour->base_price_child ?? 0) }}"
                data-infant="{{ (int) ($tour->base_price_infant ?? 0) }}"
                data-private="{{ (int) ($tour->private_tour_price ?? 0) }}"
                data-currency="{{ $tour->currency ?? 'USD' }}">
                <div class="text-3xl font-bold text-slate-900">{{ $tour->getFormattedPriceAttribute() }}</div>
                <div class="text-xs text-slate-500">per person</div>

                <div class="mt-4 space-y-3">
                    <div>
                        <label class="text-xs font-semibold text-slate-500">Select date</label>
                        <select id="booking-date" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
                            <option value="">Pick a date</option>
                            @foreach ($scheduleDates as $schedule)
                                <option value="{{ $schedule->departure_date?->format('Y-m-d') }}">{{ $schedule->departure_date?->format('M d, Y') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500">Duration (days)</label>
                        <input type="text" value="{{ $tour->duration_days }}" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm" readonly>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500">Booking type</label>
                        <select id="booking-type" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
                            <option value="group">Group / Individual</option>
                            <option value="private">Private</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="text-xs text-slate-500">Adult</label>
                            <input id="count-adult" type="number" min="0" value="1" class="mt-1 w-full rounded-md border border-slate-300 px-2 py-2 text-sm">
                        </div>
                        <div>
                            <label class="text-xs text-slate-500">Child</label>
                            <input id="count-child" type="number" min="0" value="0" class="mt-1 w-full rounded-md border border-slate-300 px-2 py-2 text-sm">
                        </div>
                        <div>
                            <label class="text-xs text-slate-500">Infant</label>
                            <input id="count-infant" type="number" min="0" value="0" class="mt-1 w-full rounded-md border border-slate-300 px-2 py-2 text-sm">
                        </div>
                    </div>
                </div>

                <div class="mt-4 rounded-lg bg-slate-100 p-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span id="selected-date-label">Select a date</span>
                        <span id="selected-date-amount">-</span>
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                        <span>Total</span>
                        <strong id="booking-total">{{ $tour->getFormattedPriceAttribute() }}</strong>
                    </div>
                </div>

                <button type="button" class="btn-orange mt-4 w-full">Book Now</button>
            </div>
        </aside>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 pb-14">
    <h2 class="text-3xl font-bold">Related Packages</h2>
    <div class="mt-6 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($relatedTours as $related)
            @php
                $thumb = $related->getFirstMedia('thumbnail');
                $thumbUrl = $thumb ? ($thumb->hasGeneratedConversion('thumb') ? $thumb->getUrl('thumb') : $thumb->getUrl()) : null;
            @endphp
            <article class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                <a href="{{ route('tours.show', $related->slug) }}" class="block">
                    @if ($thumbUrl)
                        <img src="{{ $thumbUrl }}" alt="{{ $related->title }}" class="h-44 w-full rounded-xl object-cover">
                    @else
                        <div class="h-44 w-full rounded-xl bg-slate-100"></div>
                    @endif
                    <h3 class="mt-3 text-sm font-semibold text-slate-900">{{ $related->title }}</h3>
                    <div class="mt-2 text-sm font-semibold text-green-600">{{ $related->getFormattedPriceAttribute() }}</div>
                </a>
            </article>
        @empty
            <p class="text-sm text-slate-500">No related packages found.</p>
        @endforelse
    </div>
</section>

<div id="tour-gallery-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/90 px-4 py-6">
    <div class="mx-auto flex min-h-full max-w-6xl flex-col justify-center gap-4">
        <div class="flex items-center justify-between text-white">
            <div>
                <h3 class="text-xl font-semibold">All Photos</h3>
                <p class="text-sm text-white/70">Scroll to browse and use arrows to switch image.</p>
            </div>
            <button type="button" data-gallery-close class="rounded-full border border-white/20 px-4 py-2 text-sm font-semibold text-white">Close</button>
        </div>

        <div class="rounded-2xl bg-black/40 p-3">
            <div class="flex items-center justify-between gap-3">
                <button type="button" data-gallery-prev class="rounded-full bg-white/10 px-4 py-3 text-white">←</button>
                <div class="flex-1">
                    <img id="gallery-modal-image" src="" alt="Gallery preview" class="mx-auto max-h-[70vh] w-auto rounded-xl object-contain">
                </div>
                <button type="button" data-gallery-next class="rounded-full bg-white/10 px-4 py-3 text-white">→</button>
            </div>
        </div>

        <div class="overflow-x-auto pb-2">
            <div id="gallery-thumb-strip" class="flex gap-3"></div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        (function () {
            const gallery = @json($galleryData);
            const bookingCard = document.getElementById('booking-card');
            const bookingType = document.getElementById('booking-type');
            const adultCount = document.getElementById('count-adult');
            const childCount = document.getElementById('count-child');
            const infantCount = document.getElementById('count-infant');
            const bookingDate = document.getElementById('booking-date');
            const totalEl = document.getElementById('booking-total');
            const selectedDateLabel = document.getElementById('selected-date-label');
            const selectedDateAmount = document.getElementById('selected-date-amount');
            const shareButton = document.querySelector('[data-share-tour]');
            const likeButton = document.querySelector('[data-like-tour]');
            const likeIcon = document.querySelector('[data-like-icon]');
            const likeLabel = document.querySelector('[data-like-label]');

            const modal = document.getElementById('tour-gallery-modal');
            const modalImage = document.getElementById('gallery-modal-image');
            const strip = document.getElementById('gallery-thumb-strip');
            const openGallery = document.querySelector('[data-gallery-open]');
            const closeGallery = document.querySelector('[data-gallery-close]');
            const prevGallery = document.querySelector('[data-gallery-prev]');
            const nextGallery = document.querySelector('[data-gallery-next]');
            const tabButtons = document.querySelectorAll('[data-tour-tab]');
            const tabPanels = document.querySelectorAll('[data-tour-panel]');

            if (!bookingCard || !modal || !modalImage || !strip) {
                return;
            }

            const currency = bookingCard.dataset.currency || 'USD';
            const formatter = new Intl.NumberFormat(undefined, {
                style: 'currency',
                currency,
                maximumFractionDigits: 0,
            });

            let currentIndex = 0;

            const renderModal = () => {
                if (!gallery.length) {
                    return;
                }

                modalImage.src = gallery[currentIndex].url;
                strip.innerHTML = '';

                gallery.forEach((item, index) => {
                    const thumb = document.createElement('button');
                    thumb.type = 'button';
                    thumb.className = 'shrink-0 overflow-hidden rounded-xl border transition ' + (index === currentIndex ? 'border-orange' : 'border-white/20');
                    thumb.innerHTML = `<img src="${item.thumb}" alt="${item.alt}" class="h-20 w-28 object-cover md:h-24 md:w-36">`;
                    thumb.addEventListener('click', () => {
                        currentIndex = index;
                        renderModal();
                    });
                    strip.appendChild(thumb);
                });
            };

            const openModal = (index = 0) => {
                currentIndex = index;
                renderModal();
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            };

            openGallery?.addEventListener('click', () => openModal(0));
            closeGallery?.addEventListener('click', closeModal);
            prevGallery?.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + gallery.length) % gallery.length;
                renderModal();
            });
            nextGallery?.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % gallery.length;
                renderModal();
            });

            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (modal.classList.contains('hidden')) {
                    return;
                }

                if (event.key === 'Escape') {
                    closeModal();
                }

                if (event.key === 'ArrowLeft') {
                    currentIndex = (currentIndex - 1 + gallery.length) % gallery.length;
                    renderModal();
                }

                if (event.key === 'ArrowRight') {
                    currentIndex = (currentIndex + 1) % gallery.length;
                    renderModal();
                }
            });

            const calculateTotal = () => {
                const adult = Number(adultCount?.value || 0);
                const child = Number(childCount?.value || 0);
                const infant = Number(infantCount?.value || 0);
                const type = bookingType?.value || 'group';
                const prices = {
                    adult: Number(bookingCard.dataset.adult || 0),
                    child: Number(bookingCard.dataset.child || 0),
                    infant: Number(bookingCard.dataset.infant || 0),
                    private: Number(bookingCard.dataset.private || 0),
                };

                const total = type === 'private' && prices.private > 0
                    ? prices.private
                    : adult * prices.adult + child * prices.child + infant * prices.infant;

                if (totalEl) {
                    totalEl.textContent = formatter.format(total);
                }

                if (selectedDateAmount) {
                    selectedDateAmount.textContent = formatter.format(total);
                }

                if (selectedDateLabel) {
                    selectedDateLabel.textContent = bookingDate?.value || 'Select a date';
                }
            };

            [bookingType, adultCount, childCount, infantCount, bookingDate].forEach((input) => {
                input?.addEventListener('input', calculateTotal);
                input?.addEventListener('change', calculateTotal);
            });

            const setTab = (tab) => {
                tabPanels.forEach((panel) => {
                    panel.classList.toggle('hidden', panel.dataset.tourPanel !== tab);
                });

                tabButtons.forEach((button) => {
                    const active = button.dataset.tourTab === tab;
                    button.classList.toggle('text-orange', active);
                    button.classList.toggle('border-b-2', active);
                    button.classList.toggle('border-orange', active);
                });
            };

            tabButtons.forEach((button) => {
                button.addEventListener('click', () => setTab(button.dataset.tourTab));
            });

            setTab('overview');
            calculateTotal();

            const likedKey = `tour-like-${window.location.pathname}`;
            const syncLikeState = (state) => {
                likeIcon.textContent = state ? '♥' : '♡';
                likeLabel.textContent = state ? 'Liked' : 'Like';
                likeButton.classList.toggle('border-orange', state);
                likeButton.classList.toggle('text-orange', state);
            };

            syncLikeState(localStorage.getItem(likedKey) === '1');

            likeButton?.addEventListener('click', () => {
                const nextState = localStorage.getItem(likedKey) !== '1';
                localStorage.setItem(likedKey, nextState ? '1' : '0');
                syncLikeState(nextState);
            });

            shareButton?.addEventListener('click', async () => {
                const shareData = { title: document.title, text: '{{ $tour->title }}', url: window.location.href };

                try {
                    if (navigator.share) {
                        await navigator.share(shareData);
                    } else {
                        await navigator.clipboard.writeText(window.location.href);
                        alert('Tour link copied to clipboard.');
                    }
                } catch (error) {
                    try {
                        await navigator.clipboard.writeText(window.location.href);
                        alert('Tour link copied to clipboard.');
                    } catch (clipboardError) {
                        console.error(clipboardError);
                    }
                }
            });
        })();
    </script>
@endpush
@endsection
