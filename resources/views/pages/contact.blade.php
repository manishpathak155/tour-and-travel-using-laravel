@extends('layouts.app')

@section('content')
<section class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-16">
        <p class="section-eyebrow">Contact Us</p>
        <h1 class="text-4xl font-bold text-slate-900 md:text-5xl">Plan your trek with our travel designers.</h1>
        <p class="mt-4 text-slate-600">We respond within 24 hours. WhatsApp us for quick itinerary advice.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-12">
    <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
        <form class="rounded-3xl border border-slate-100 bg-white p-8 shadow-sm">
            <div class="grid gap-5 md:grid-cols-2">
                <input class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm" placeholder="Full name">
                <input class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm" placeholder="Email address">
                <input class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm" placeholder="Phone number">
                <input class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm" placeholder="Preferred destination">
            </div>
            <textarea class="mt-5 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm" rows="5" placeholder="Tell us about your ideal trek..."></textarea>
            <button class="btn-orange mt-6">Send Inquiry</button>
        </form>

        <div class="space-y-6">
            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-semibold">Altivaro Treks</h2>
                <p class="mt-2 text-sm text-slate-600">{{ setting('general.address', 'Kathmandu, Nepal') }}</p>
                <p class="mt-4 text-sm text-slate-600">{{ setting('general.contact_phone', '+977 9851175531') }}</p>
                <p class="text-sm text-slate-600">{{ setting('general.contact_email', 'info@altivarotreks.com') }}</p>
            </div>
            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold">WhatsApp</h3>
                <p class="mt-2 text-sm text-slate-600">Tap to chat with our team instantly.</p>
                <a href="https://wa.me/{{ setting('general.whatsapp_number', '9779851175531') }}" target="_blank" class="btn-orange mt-4 w-full">Chat on WhatsApp</a>
            </div>
        </div>
    </div>
</section>
@endsection
