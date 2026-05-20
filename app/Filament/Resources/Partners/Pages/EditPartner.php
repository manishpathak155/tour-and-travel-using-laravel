<?php

namespace App\Filament\Resources\Partners\Pages;

use App\Filament\Resources\Partners\PartnerResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit a partner.
 */
class EditPartner extends EditRecord
{
    protected static string $resource = PartnerResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
