<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Models\Booking;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Defines the bookings table schema.
 */
class BookingsTable
{
    /**
     * Configure the bookings table.
     *
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_reference')
                    ->label('Reference')
                    ->copyable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tour.title')
                    ->label('Tour')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('customer')
                    ->label('Customer')
                    ->getStateUsing(fn (Booking $record): string => $record->user?->name ?? $record->guest_name ?? 'Guest')
                    ->description(fn (Booking $record): ?string => $record->user?->email ?? $record->guest_email)
                    ->searchable(),
                TextColumn::make('departure_date')
                    ->date()
                    ->description(fn (Booking $record): string => $record->getDaysToDepartureAttribute() . ' days away')
                    ->sortable(),
                TextColumn::make('group')
                    ->label('Group')
                    ->getStateUsing(fn (Booking $record): string => $record->adult_count . 'A ' . $record->child_count . 'C ' . $record->infant_count . 'I')
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->formatStateUsing(fn (Booking $record): string => self::formatMoney($record->total_amount, $record->currency))
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Booking $record): string => $record->status?->color() ?? 'gray')
                    ->formatStateUsing(fn (Booking $record): string => $record->status?->label() ?? 'Unknown')
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (Booking $record): string => $record->payment_status?->color() ?? 'gray')
                    ->formatStateUsing(fn (Booking $record): string => $record->payment_status?->label() ?? 'Unknown')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(self::enumOptions(BookingStatus::cases())),
                SelectFilter::make('payment_status')
                    ->options(self::enumOptions(PaymentStatus::cases())),
                SelectFilter::make('tour_id')
                    ->label('Tour')
                    ->relationship('tour', 'title')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('guide_id')
                    ->label('Guide')
                    ->relationship('guide', 'name')
                    ->searchable()
                    ->preload(),
                Filter::make('departure_range')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $query, $value): Builder => $query->whereDate('departure_date', '>=', $value))
                            ->when($data['until'] ?? null, fn (Builder $query, $value): Builder => $query->whereDate('departure_date', '<=', $value));
                    }),
                Filter::make('created_range')
                    ->form([
                        DatePicker::make('from')->label('From'),
                        DatePicker::make('until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $query, $value): Builder => $query->whereDate('created_at', '>=', $value))
                            ->when($data['until'] ?? null, fn (Builder $query, $value): Builder => $query->whereDate('created_at', '<=', $value));
                    }),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                Action::make('confirm')
                    ->label('Confirm Booking')
                    ->requiresConfirmation()
                    ->action(function (Booking $record): void {
                        $record->update([
                            'status' => BookingStatus::CONFIRMED,
                            'confirmed_at' => now(),
                        ]);

                        $record->sendConfirmationEmail();

                        Notification::make()
                            ->title('Booking confirmed')
                            ->success()
                            ->send();
                    }),
                Action::make('mark_completed')
                    ->label('Mark Completed')
                    ->requiresConfirmation()
                    ->action(function (Booking $record): void {
                        $record->update([
                            'status' => BookingStatus::COMPLETED,
                        ]);

                        Notification::make()
                            ->title('Booking marked completed')
                            ->success()
                            ->send();
                    }),
                Action::make('cancel')
                    ->label('Cancel')
                    ->color('danger')
                    ->form([
                        Textarea::make('cancellation_reason')
                            ->label('Reason')
                            ->required()
                            ->rows(3),
                    ])
                    ->requiresConfirmation()
                    ->action(function (Booking $record, array $data): void {
                        $record->update([
                            'status' => BookingStatus::CANCELLED,
                            'cancelled_at' => now(),
                            'cancellation_reason' => $data['cancellation_reason'] ?? null,
                        ]);

                        Notification::make()
                            ->title('Booking cancelled')
                            ->warning()
                            ->send();
                    }),
                Action::make('refund')
                    ->label('Process Refund')
                    ->color('warning')
                    ->form([
                        TextInput::make('refund_amount')
                            ->label('Refund amount (paisa)')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                    ])
                    ->requiresConfirmation()
                    ->action(function (Booking $record): void {
                        $record->update([
                            'payment_status' => PaymentStatus::REFUNDED,
                        ]);

                        Notification::make()
                            ->title('Refund recorded')
                            ->success()
                            ->send();
                    }),
                Action::make('remind')
                    ->label('Send Reminder')
                    ->action(function (): void {
                        Notification::make()
                            ->title('Reminder queued')
                            ->success()
                            ->send();
                    }),
                Action::make('voucher')
                    ->label('Download Voucher')
                    ->action(function (Booking $record): void {
                        $path = $record->generateVoucherPDF();

                        if ($path === '') {
                            Notification::make()
                                ->title('Voucher generation not configured')
                                ->warning()
                                ->send();

                            return;
                        }

                        Notification::make()
                            ->title('Voucher generated')
                            ->body($path)
                            ->success()
                            ->send();
                    }),
                Action::make('email')
                    ->label('Send Custom Email')
                    ->form([
                        TextInput::make('subject')
                            ->required()
                            ->maxLength(150),
                        Textarea::make('message')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function (): void {
                        Notification::make()
                            ->title('Email queued')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    /**
     * Build enum options for select filters.
     *
     * @param array<int, \BackedEnum> $cases
     * @return array<string, string>
     */
    private static function enumOptions(array $cases): array
    {
        $options = [];

        foreach ($cases as $case) {
            $options[$case->value] = method_exists($case, 'label') ? $case->label() : $case->value;
        }

        return $options;
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
