<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Booking;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

/**
 * Defines the booking infolist schema.
 */
class BookingInfolist
{
    /**
     * Configure the booking infolist.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Booking Summary')
                    ->schema([
                        TextEntry::make('booking_reference')
                            ->label('Reference')
                            ->copyable(),
                        TextEntry::make('tour.title')
                            ->label('Tour'),
                        TextEntry::make('schedule.departure_date')
                            ->label('Departure')
                            ->date(),
                        TextEntry::make('schedule.return_date')
                            ->label('Return')
                            ->date(),
                        TextEntry::make('status')
                            ->badge(),
                        TextEntry::make('payment_status')
                            ->label('Payment status')
                            ->badge(),
                        TextEntry::make('created_at')
                            ->dateTime(),
                    ])
                    ->columns(3),
                Section::make('Travelers')
                    ->schema([
                        TextEntry::make('adult_count')
                            ->label('Adults'),
                        TextEntry::make('child_count')
                            ->label('Children'),
                        TextEntry::make('infant_count')
                            ->label('Infants'),
                    ])
                    ->columns(3),
                Section::make('Customer Details')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Customer'),
                        TextEntry::make('user.email')
                            ->label('Customer email'),
                        TextEntry::make('guest_name')
                            ->label('Guest name'),
                        TextEntry::make('guest_email')
                            ->label('Guest email'),
                        TextEntry::make('guest_phone')
                            ->label('Guest phone'),
                    ])
                    ->columns(3),
                Section::make('Financials')
                    ->schema([
                        TextEntry::make('base_amount')
                            ->label('Base amount')
                            ->formatStateUsing(fn (Booking $record): string => self::formatMoney($record->base_amount, $record->currency)),
                        TextEntry::make('addon_amount')
                            ->label('Add-ons')
                            ->formatStateUsing(fn (Booking $record): string => self::formatMoney($record->addon_amount, $record->currency)),
                        TextEntry::make('discount_amount')
                            ->label('Discount')
                            ->formatStateUsing(fn (Booking $record): string => self::formatMoney($record->discount_amount, $record->currency)),
                        TextEntry::make('tax_amount')
                            ->label('Tax')
                            ->formatStateUsing(fn (Booking $record): string => self::formatMoney($record->tax_amount, $record->currency)),
                        TextEntry::make('total_amount')
                            ->label('Total')
                            ->formatStateUsing(fn (Booking $record): string => self::formatMoney($record->total_amount, $record->currency)),
                        TextEntry::make('deposit_amount')
                            ->label('Deposit')
                            ->formatStateUsing(fn (Booking $record): string => self::formatMoney($record->deposit_amount, $record->currency)),
                        TextEntry::make('balance_amount')
                            ->label('Balance')
                            ->formatStateUsing(fn (Booking $record): string => self::formatMoney($record->balance_amount, $record->currency)),
                    ])
                    ->columns(3),
            ]);
    }

    /**
     * Format money stored in minor units.
     *
     * @param int|null $amount
     * @param string|null $currency
     * @return string
     */
    private static function formatMoney(?int $amount, ?string $currency): string
    {
        $value = (int) ($amount ?? 0);
        $prefix = ($currency ?? 'USD') === 'USD' ? 'US$' : ($currency ?? 'USD');

        return $prefix . ' ' . number_format($value / 100, 0);
    }
}
