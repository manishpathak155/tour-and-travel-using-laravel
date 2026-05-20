<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ setting('general.site_name', 'Altivaro Treks') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-white">
        <header data-nav class="sticky top-0 z-50 bg-white text-slate-900">
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between gap-6 px-6 py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/altivaro-logo.png') }}" alt="Altivaro Treks logo" class="h-9 w-auto">
                    <span class="font-heading text-lg font-bold tracking-wide">Altivaro Treks</span>
                </a>

                <nav class="hidden items-center gap-6 xl:flex">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                    <a href="{{ route('tours.index') }}" class="nav-link">Destinations</a>
                    <a href="{{ route('tours.index') }}" class="nav-link">Trek Packages</a>
                    <a href="{{ route('blog.guides') }}" class="nav-link">Travel Guides</a>
                    <a href="{{ route('about') }}" class="nav-link">About</a>
                    <a href="{{ route('blog.index') }}" class="nav-link">Blog</a>
                    <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                </nav>

                <div class="flex items-center gap-3">
                    <button type="button" data-search-trigger class="hidden nav-cta xl:inline-flex">
                        Search
                    </button>
                    <button type="button" data-mobile-trigger class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-300 lg:hidden">
                        <span class="sr-only">Open menu</span>
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <div data-mobile-menu class="fixed inset-0 z-40 hidden bg-white text-slate-900">
                <div class="flex items-center justify-between px-6 py-4">
                    <span class="font-heading text-lg font-bold">Menu</span>
                    <button type="button" data-mobile-trigger class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-300">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <nav class="flex flex-col gap-4 px-6 text-lg font-semibold">
                    <a href="{{ route('home') }}" class="border-b border-slate-200 pb-2">Home</a>
                    <a href="{{ route('tours.index') }}" class="border-b border-slate-200 pb-2">Destinations</a>
                    <a href="{{ route('tours.index') }}" class="border-b border-slate-200 pb-2">Trek Packages</a>
                    <a href="{{ route('blog.guides') }}" class="border-b border-slate-200 pb-2">Travel Guides</a>
                    <a href="{{ route('about') }}" class="border-b border-slate-200 pb-2">About</a>
                    <a href="{{ route('blog.index') }}" class="border-b border-slate-200 pb-2">Blog</a>
                    <a href="{{ route('contact') }}" class="border-b border-slate-200 pb-2">Contact</a>
                </nav>
            </div>
        </header>

        <div data-search-overlay class="fixed inset-0 z-50 hidden bg-white px-6 py-20 text-slate-900">
            <div class="mx-auto flex max-w-3xl flex-col gap-6">
                <div class="flex items-center justify-between">
                    <h2 class="font-heading text-2xl">Search Altivaro Treks</h2>
                    <button type="button" data-search-trigger class="text-sm uppercase tracking-[0.2em] text-orange">Close</button>
                </div>
                <input type="text" placeholder="Search treks, destinations, guides..." class="w-full rounded-full border border-slate-300 bg-white px-6 py-4 text-slate-900 placeholder:text-slate-400">
                <p class="text-sm text-slate-500">Press enter to search across tours, destinations, and travel guides.</p>
            </div>
        </div>

        <main>
            @yield('content')
        </main>

        <footer id="contact" class="border-t border-slate-200 bg-white text-slate-900">
            <div class="mx-auto grid max-w-7xl gap-10 px-6 py-16 md:grid-cols-4">
                <div>
                    <h3 class="font-heading text-xl">{{ setting('general.site_name', 'Altivaro Treks') }}</h3>
                    <p class="mt-4 text-sm text-slate-500">{{ setting('general.tagline', 'Connecting Trekkers to the Himalayas') }}</p>
                </div>
                <div>
                    <h4 class="font-heading text-sm uppercase tracking-[0.2em] text-slate-400">Quick Links</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li><a href="{{ route('tours.index') }}" class="hover:text-orange">Trekking in Nepal</a></li>
                        <li><a href="{{ route('blog.guides') }}" class="hover:text-orange">Travel Guides</a></li>
                        <li><a href="{{ route('blog.index') }}" class="hover:text-orange">Blog</a></li>
                        <li><a href="{{ route('tours.index') }}" class="hover:text-orange">Top 10 Treks</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-heading text-sm uppercase tracking-[0.2em] text-slate-400">Popular Destinations</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li>Everest Region</li>
                        <li>Annapurna Region</li>
                        <li>Langtang Valley</li>
                        <li>Manaslu Circuit</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-heading text-sm uppercase tracking-[0.2em] text-slate-400">Contact</h4>
                    <ul class="mt-4 space-y-2 text-sm">
                        <li>{{ setting('general.contact_email', 'info@altivarotreks.com') }}</li>
                        <li>{{ setting('general.contact_phone', '+977 9851175531') }}</li>
                        <li>{{ setting('general.address', 'Kathmandu, Nepal') }}</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-200 py-6 text-center text-xs text-slate-400">
                © {{ now()->year }} Altivaro Treks Pvt. Ltd. All rights reserved.
            </div>
        </footer>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        if (typeof AOS !== 'undefined') {
            AOS.init({ once: true, duration: 800 });
        }
    </script>
    @stack('scripts')
</body>
</html>
