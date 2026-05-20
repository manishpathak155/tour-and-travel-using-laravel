@extends('layouts.app')

@section('content')
<section class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-16">
        <p class="section-eyebrow">Trekking in Nepal</p>
        <h1 class="text-4xl font-bold text-slate-900 md:text-5xl">Find your perfect Himalayan trek.</h1>
        <p class="mt-4 max-w-2xl text-slate-600">Curated itineraries across Everest, Annapurna, Langtang, and the hidden valleys beyond.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-12">
    <div class="grid gap-8 lg:grid-cols-[320px_1fr]">
        <aside class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
            <form method="GET" class="space-y-5">
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Keyword</label>
                    <input name="q" value="{{ request('q') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm" placeholder="Everest, Annapurna...">
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Destination</label>
                    <select name="destination" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm">
                        <option value="">All destinations</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}" @selected(request('destination') == $destination->id)>{{ $destination->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Region</label>
                    <select name="region" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm">
                        <option value="">All regions</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region }}" @selected(request('region') == $region)>{{ $region }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Category</label>
                    <select name="category" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Difficulty</label>
                    <select name="difficulty" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm">
                        <option value="">Any</option>
                        <option value="easy" @selected(request('difficulty') === 'easy')>Easy</option>
                        <option value="moderate" @selected(request('difficulty') === 'moderate')>Moderate</option>
                        <option value="moderate_strenuous" @selected(request('difficulty') === 'moderate_strenuous')>Moderate - Strenuous</option>
                        <option value="strenuous" @selected(request('difficulty') === 'strenuous')>Strenuous</option>
                        <option value="extreme" @selected(request('difficulty') === 'extreme')>Extreme</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Min price</label>
                        <input name="min_price" value="{{ request('min_price') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="50000">
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Max price</label>
                        <input name="max_price" value="{{ request('max_price') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="200000">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Min days</label>
                        <input name="min_days" value="{{ request('min_days') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="3">
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Max days</label>
                        <input name="max_days" value="{{ request('max_days') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="20">
                    </div>
                </div>
                <button class="btn-orange w-full">Apply Filters</button>
            </form>
        </aside>

        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold">{{ $tours->total() }} treks available</h2>
                <span class="text-sm text-slate-500">Showing {{ $tours->count() }} results</span>
            </div>
            <div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($tours as $tour)
                    <a href="{{ route('tours.show', $tour->slug) }}" class="group rounded-3xl border border-slate-100 bg-white p-5 shadow-sm transition hover:-translate-y-1">
                        <div class="relative overflow-hidden rounded-2xl bg-slate-100">
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
                            @if ($tour->is_best_seller)
                                <span class="absolute left-4 top-4 rounded-full bg-orange px-3 py-1 text-xs font-semibold text-white">Best Seller</span>
                            @endif
                        </div>
                        <div class="mt-4 space-y-2">
                            <div class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">
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
                    </a>
                @empty
                    <p class="text-slate-500">No tours matched your filters.</p>
                @endforelse
            </div>
            <div class="mt-8">
                {{ $tours->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
