@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-7xl px-6 py-20">
        <h1 class="text-3xl font-bold">Welcome to Altivaro Treks</h1>
        <p class="mt-4 text-slate-600">Homepage is now available. Visit <a href="{{ route('home') }}" class="text-orange">Home</a>.</p>
    </div>
@endsection
