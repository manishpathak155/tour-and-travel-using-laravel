<?php

namespace App\Filament\Resources\Reviews\Pages;

use App\Filament\Resources\Reviews\ReviewResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit a review.
 */
class EditReview extends EditRecord
{
    protected static string $resource = ReviewResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
