<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Defines the inquiry form schema.
 */
class InquiryForm
{
    /**
     * Configure the inquiry form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Inquiry Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(120),
                                TextInput::make('email')
                                    ->email()
                                    ->maxLength(120),
                                TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(40),
                                TextInput::make('nationality')
                                    ->maxLength(100),
                                Select::make('tour_id')
                                    ->label('Tour')
                                    ->relationship('tour', 'title')
                                    ->searchable()
                                    ->preload(),
                                DatePicker::make('travel_date')
                                    ->label('Travel date'),
                                TextInput::make('group_size')
                                    ->numeric()
                                    ->minValue(1),
                                TextInput::make('budget_range')
                                    ->maxLength(100),
                                TextInput::make('source')
                                    ->maxLength(100),
                                Select::make('status')
                                    ->options([
                                        'new' => 'New',
                                        'in_progress' => 'In Progress',
                                        'replied' => 'Replied',
                                        'closed' => 'Closed',
                                    ])
                                    ->required(),
                                Select::make('assigned_to')
                                    ->label('Assigned to')
                                    ->relationship('assignedTo', 'name')
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Textarea::make('message')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
