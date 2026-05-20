<?php

namespace App\Filament\Resources\Tours\Pages;

use App\Filament\Resources\Tours\TourResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit a tour.
 */
class EditTour extends EditRecord
{
    protected static string $resource = TourResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
