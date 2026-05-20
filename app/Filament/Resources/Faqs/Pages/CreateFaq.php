<?php

namespace App\Filament\Resources\Faqs\Pages;

use App\Filament\Resources\Faqs\FaqResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Create a FAQ.
 */
class CreateFaq extends CreateRecord
{
    protected static string $resource = FaqResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
