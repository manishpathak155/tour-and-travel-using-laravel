<?php

namespace App\Filament\Resources\Inquiries\Pages;

use App\Filament\Resources\Inquiries\InquiryResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit an inquiry.
 */
class EditInquiry extends EditRecord
{
    protected static string $resource = InquiryResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
