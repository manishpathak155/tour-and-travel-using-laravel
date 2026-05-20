<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Defines the review form schema.
 */
class ReviewForm
{
    /**
     * Configure the review form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Review')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('tour_id')
                                    ->label('Tour')
                                    ->relationship('tour', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('user_id')
                                    ->label('User')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('booking_id')
                                    ->label('Booking')
                                    ->relationship('booking', 'booking_reference')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('overall_rating')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(5)
                                    ->required(),
                                TextInput::make('guide_rating')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(5),
                                TextInput::make('accommodation_rating')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(5),
                                TextInput::make('value_rating')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(5),
                                TextInput::make('safety_rating')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(5),
                            ]),
                        TextInput::make('title')
                            ->maxLength(255),
                        Textarea::make('body')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('pros')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('cons')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('admin_response')
                            ->rows(3)
                            ->columnSpanFull(),
                        Grid::make(3)
                            ->schema([
                                Toggle::make('is_verified')
                                    ->label('Verified'),
                                Toggle::make('is_published')
                                    ->label('Published'),
                                TextInput::make('helpful_count')
                                    ->numeric()
                                    ->minValue(0),
                            ]),
                    ]),
            ]);
    }
}
