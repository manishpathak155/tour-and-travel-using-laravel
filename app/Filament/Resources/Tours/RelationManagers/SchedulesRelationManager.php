<?php

namespace App\Filament\Resources\Tours\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Actions\DeleteAction;
use Filament\Schemas\Components\Grid;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Manage tour schedules.
 */
class SchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'schedules';

    /**
     * Build the schedule form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        DatePicker::make('departure_date')
                            ->required(),
                        DatePicker::make('return_date')
                            ->required(),
                        TextInput::make('total_seats')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                        TextInput::make('booked_seats')
                            ->numeric()
                            ->minValue(0)
                            ->default(0),
                        TextInput::make('price_override_adult')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('US$'),
                        TextInput::make('original_price_override')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('US$'),
                        Select::make('status')
                            ->options([
                                'open' => 'Open',
                                'guaranteed' => 'Guaranteed',
                                'full' => 'Full',
                                'closed' => 'Closed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                        TextInput::make('notes')
                            ->maxLength(255),
                    ]),
                ]);
    }

    /**
     * Build the schedule table.
     *
     * @param Table $table
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('departure_date')
                    ->date(),
                TextColumn::make('return_date')
                    ->date(),
                TextColumn::make('total_seats')
                    ->label('Total'),
                TextColumn::make('booked_seats')
                    ->label('Booked'),
                TextColumn::make('available_seats')
                    ->label('Available')
                    ->getStateUsing(fn ($record): int => max(0, (int) $record->total_seats - (int) $record->booked_seats)),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('price_override_adult')
                    ->label('Price override'),
                IconColumn::make('is_guaranteed')
                    ->label('Guaranteed')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
