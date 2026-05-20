<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\ViewRecord;

/**
 * View a booking.
 */
class ViewBooking extends ViewRecord
{
    protected static string $resource = BookingResource::class;
}
