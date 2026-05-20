<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $tour->title }} - Itinerary</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.45;
        }

        h1 {
            font-size: 22px;
            margin: 0 0 6px;
        }

        h2 {
            font-size: 14px;
            margin: 18px 0 8px;
        }

        .meta {
            color: #4b5563;
            margin-bottom: 14px;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .day-title {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .small {
            color: #6b7280;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <h1>{{ $tour->title }}</h1>
    <div class="meta">
        {{ $tour->destination?->name ?? 'Nepal' }} | {{ $tour->duration_days }} Days / {{ $tour->duration_nights }} Nights
    </div>

    @if (!empty($tour->short_description))
        <p>{{ $tour->short_description }}</p>
    @endif

    <h2>Day-by-Day Itinerary</h2>

    @forelse ($itineraries as $day)
        <div class="card">
            <div class="day-title">Day {{ $day->day_number }}: {{ $day->title }}</div>
            @if (!empty($day->walking_hours) || !empty($day->distance_km) || !empty($day->max_altitude_meters))
                <div class="small">
                    @if (!empty($day->walking_hours)) Walking Hours: {{ $day->walking_hours }} @endif
                    @if (!empty($day->distance_km)) | Distance: {{ $day->distance_km }} km @endif
                    @if (!empty($day->max_altitude_meters)) | Max Altitude: {{ $day->max_altitude_meters }} m @endif
                </div>
            @endif
            <div>{!! $day->description !!}</div>
        </div>
    @empty
        <p>No itinerary entries available.</p>
    @endforelse

    <p class="small">Generated on {{ now()->format('Y-m-d H:i') }}</p>
</body>
</html>
