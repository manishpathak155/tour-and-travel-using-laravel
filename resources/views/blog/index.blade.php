@extends('layouts.app')

@section('content')
<section class="bg-white">
    <div class="mx-auto max-w-7xl px-6 py-16">
        <p class="section-eyebrow">Altivaro Journal</p>
        <h1 class="text-4xl font-bold text-slate-900 md:text-5xl">Stories, tips, and trek planning advice.</h1>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 py-12">
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1">
                <div class="aspect-[4/3] rounded-2xl bg-slate-100"></div>
                <div class="mt-4 space-y-2">
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $post->post_type === 'travel_guide' ? 'Travel Guide' : 'Blog' }}</span>
                    <h3 class="text-lg font-semibold text-slate-900">{{ $post->title }}</h3>
                    <p class="text-sm text-slate-600">{{ $post->excerpt }}</p>
                </div>
            </a>
        @empty
            <p class="text-slate-500">No blog posts published yet.</p>
        @endforelse
    </div>
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</section>
@endsection
