<?php

namespace App\Filament\Resources\Bookings;

use App\Filament\Resources\Bookings\Pages\EditBooking;
use App\Filament\Resources\Bookings\Pages\ListBookings;
use App\Filament\Resources\Bookings\Pages\ViewBooking;
use App\Filament\Resources\Bookings\RelationManagers\AddonsRelationManager;
use App\Filament\Resources\Bookings\RelationManagers\PaymentsRelationManager;
use App\Filament\Resources\Bookings\RelationManagers\TravelersRelationManager;
use App\Filament\Resources\Bookings\Schemas\BookingForm;
use App\Filament\Resources\Bookings\Schemas\BookingInfolist;
use App\Filament\Resources\Bookings\Tables\BookingsTable;
use App\Models\Booking;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

/**
 * Filament resource for bookings.
 */
class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|UnitEnum|null $navigationGroup = 'Booking Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'booking_reference';

    /**
     * Build the resource form schema.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return BookingForm::configure($schema);
    }

    /**
     * Build the resource infolist schema.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function infolist(Schema $schema): Schema
    {
        return BookingInfolist::configure($schema);
    }

    /**
     * Build the resource table schema.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return BookingsTable::configure($table);
    }

    /**
     * Get the resource relations.
     *
     * @return array<int, mixed>
     */
    public static function getRelations(): array
    {
        return [
            TravelersRelationManager::class,
            AddonsRelationManager::class,
            PaymentsRelationManager::class,
        ];
    }

    /**
     * Get the resource pages.
     *
     * @return array<string, mixed>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'view' => ViewBooking::route('/{record}'),
            'edit' => EditBooking::route('/{record}/edit'),
        ];
    }

    /**
     * Get the navigation badge count for pending bookings.
     *
     * @return string|null
     */
    public static function getNavigationBadge(): ?string
    {
        $count = Booking::query()->where('status', 'pending')->count();

        return $count > 0 ? (string) $count : null;
    }
}
