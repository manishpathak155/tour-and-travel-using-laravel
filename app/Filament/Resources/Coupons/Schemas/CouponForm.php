<?php

namespace App\Filament\Resources\Coupons\Schemas;

use App\Models\Tour;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Defines the coupon form schema.
 */
class CouponForm
{
    /**
     * Configure the coupon form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Coupon details')
                    ->schema([
                        Hidden::make('created_by')
                            ->default(fn (): ?int => auth()->id())
                            ->dehydrated(),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('code')
                                    ->required()
                                    ->maxLength(50)
                                    ->unique(ignoreRecord: true),
                                TextInput::make('description')
                                    ->maxLength(500),
                                Select::make('discount_type')
                                    ->options([
                                        'percentage' => 'Percentage',
                                        'fixed_amount' => 'Fixed amount',
                                    ])
                                    ->required(),
                                TextInput::make('discount_value')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required(),
                                TextInput::make('min_booking_amount')
                                    ->label('Minimum booking amount')
                                    ->numeric()
                                    ->minValue(0),
                                TextInput::make('max_discount_amount')
                                    ->label('Maximum discount amount')
                                    ->numeric()
                                    ->minValue(0),
                                TextInput::make('max_uses')
                                    ->label('Maximum uses')
                                    ->numeric()
                                    ->minValue(0),
                                TextInput::make('max_uses_per_user')
                                    ->label('Max uses per user')
                                    ->numeric()
                                    ->minValue(1)
                                    ->default(1),
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                            ]),
                        Grid::make(2)
                            ->schema([
                                DateTimePicker::make('valid_from')
                                    ->required(),
                                DateTimePicker::make('valid_until')
                                    ->required(),
                            ]),
                        Select::make('applicable_tour_ids')
                            ->label('Applicable tours')
                            ->multiple()
                            ->searchable()
                            ->options(Tour::query()->orderBy('title')->pluck('title', 'id')->all())
                            ->helperText('Leave empty to apply to all tours.'),
                    ]),
            ]);
    }
}
