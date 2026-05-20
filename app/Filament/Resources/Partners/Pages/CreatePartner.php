<?php

namespace App\Filament\Resources\Partners\Pages;

use App\Filament\Resources\Partners\PartnerResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Create a partner.
 */
class CreatePartner extends CreateRecord
{
    protected static string $resource = PartnerResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
