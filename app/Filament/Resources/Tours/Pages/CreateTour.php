<?php

namespace App\Filament\Resources\Tours\Pages;

use App\Filament\Resources\Tours\TourResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Create a tour.
 */
class CreateTour extends CreateRecord
{
    protected static string $resource = TourResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
