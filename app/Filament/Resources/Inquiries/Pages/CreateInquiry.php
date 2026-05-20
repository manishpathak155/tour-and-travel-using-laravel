<?php

namespace App\Filament\Resources\Inquiries\Pages;

use App\Filament\Resources\Inquiries\InquiryResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Create an inquiry.
 */
class CreateInquiry extends CreateRecord
{
    protected static string $resource = InquiryResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
