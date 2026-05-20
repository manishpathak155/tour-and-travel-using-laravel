<?php

namespace App\Filament\Resources\Reviews\Pages;

use App\Filament\Resources\Reviews\ReviewResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Create a review.
 */
class CreateReview extends CreateRecord
{
    protected static string $resource = ReviewResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
