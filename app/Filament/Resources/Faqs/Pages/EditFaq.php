<?php

namespace App\Filament\Resources\Faqs\Pages;

use App\Filament\Resources\Faqs\FaqResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit a FAQ.
 */
class EditFaq extends EditRecord
{
    protected static string $resource = FaqResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
