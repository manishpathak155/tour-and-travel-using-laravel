@extends('layouts.app')

@section('content')
<section class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-16">
        <p class="section-eyebrow">About Altivaro</p>
        <h1 class="text-4xl font-bold text-slate-900 md:text-5xl">We connect trekkers to the Himalayas with integrity.</h1>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-14">
    <div class="grid gap-10 lg:grid-cols-2">
        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-semibold">Our Story</h2>
            <p class="mt-4 text-slate-600">Altivaro Treks is built by Kathmandu-based guides who have lived the routes, the seasons, and the culture of Nepal. Every journey is curated with local expertise and an unwavering focus on safety.</p>
            <p class="mt-4 text-slate-600">From first-timers to seasoned alpinists, we create tailor-made itineraries that celebrate the Himalayas and the communities who call them home.</p>
        </div>
        <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-semibold">What We Believe</h2>
            <ul class="mt-4 space-y-3 text-slate-600">
                <li>• Safety-first decision making on every route.</li>
                <li>• Transparent pricing and honest guidance.</li>
                <li>• Sustainable tourism that supports local livelihoods.</li>
                <li>• Small group experiences for deeper cultural connection.</li>
            </ul>
        </div>
    </div>
</section>
@endsection
