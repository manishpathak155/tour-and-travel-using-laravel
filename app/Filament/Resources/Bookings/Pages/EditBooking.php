<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit a booking.
 */
class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
