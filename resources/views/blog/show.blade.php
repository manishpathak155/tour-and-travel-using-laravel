@extends('layouts.app')

@section('content')
<section class="bg-white">
    <div class="mx-auto max-w-4xl px-6 py-16">
        <p class="section-eyebrow">{{ $post->post_type === 'travel_guide' ? 'Travel Guide' : 'Blog' }}</p>
        <h1 class="mt-3 text-4xl font-bold text-slate-900 md:text-5xl">{{ $post->title }}</h1>
        <p class="mt-4 text-slate-500">By {{ $post->author?->name ?? 'Altivaro Team' }} · {{ optional($post->published_at)->format('M d, Y') }}</p>
    </div>
</section>

<section class="mx-auto max-w-4xl px-6 py-12">
    <div class="prose prose-slate max-w-none">
        {!! $post->body !!}
    </div>
</section>
@endsection
