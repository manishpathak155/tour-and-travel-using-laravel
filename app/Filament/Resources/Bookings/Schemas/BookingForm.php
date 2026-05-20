<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Defines the booking form schema.
 */
class BookingForm
{
    /**
     * Configure the booking form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Status & Assignment')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('tour_id')
                                    ->label('Tour')
                                    ->relationship('tour', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('status')
                                    ->options([
                                        'pending' => 'Pending',
                                        'confirmed' => 'Confirmed',
                                        'in_progress' => 'In Progress',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                        'refunded' => 'Refunded',
                                        'on_hold' => 'On Hold',
                                    ])
                                    ->required(),
                                Select::make('payment_status')
                                    ->label('Payment status')
                                    ->options([
                                        'unpaid' => 'Unpaid',
                                        'deposit_paid' => 'Deposit Paid',
                                        'partially_paid' => 'Partially Paid',
                                        'fully_paid' => 'Fully Paid',
                                        'refunded' => 'Refunded',
                                        'failed' => 'Failed',
                                    ])
                                    ->required(),
                                Select::make('guide_id')
                                    ->label('Assigned guide')
                                    ->relationship('guide', 'name')
                                    ->searchable()
                                    ->preload(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Section::make('Guest Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('guest_name')
                                    ->maxLength(120),
                                TextInput::make('guest_email')
                                    ->email()
                                    ->maxLength(120),
                                TextInput::make('guest_phone')
                                    ->tel()
                                    ->maxLength(40),
                                TextInput::make('guest_nationality')
                                    ->maxLength(100),
                            ]),
                    ])
                    ->columnSpanFull(),
                Section::make('Party & Dates')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('booking_type')
                                    ->options([
                                        'solo' => 'Solo',
                                        'group' => 'Group',
                                        'private' => 'Private',
                                        'corporate' => 'Corporate',
                                    ])
                                    ->required()
                                    ->default('solo'),
                                TextInput::make('adult_count')
                                    ->label('Adults')
                                    ->numeric()
                                    ->minValue(1)
                                    ->required()
                                    ->default(1),
                                TextInput::make('child_count')
                                    ->label('Children')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),
                                TextInput::make('infant_count')
                                    ->label('Infants')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),
                                DatePicker::make('departure_date')
                                    ->label('Departure date'),
                                DatePicker::make('return_date')
                                    ->label('Return date'),
                            ]),
                    ])
                    ->columnSpanFull(),
                Section::make('Financials')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('base_amount')
                                    ->label('Base amount (paisa)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),
                                TextInput::make('addon_amount')
                                    ->label('Addon amount (paisa)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),
                                TextInput::make('discount_amount')
                                    ->label('Discount amount (paisa)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),
                                TextInput::make('tax_amount')
                                    ->label('Tax amount (paisa)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),
                                TextInput::make('total_amount')
                                    ->label('Total amount (paisa)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),
                                TextInput::make('deposit_amount')
                                    ->label('Deposit amount (paisa)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),
                                TextInput::make('balance_amount')
                                    ->label('Balance amount (paisa)')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),
                                TextInput::make('currency')
                                    ->label('Currency')
                                    ->maxLength(3)
                                    ->default('USD')
                                    ->required(),
                            ]),
                    ])
                    ->columnSpanFull(),
                Section::make('Notes')
                    ->schema([
                        Textarea::make('special_requests')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('internal_notes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
