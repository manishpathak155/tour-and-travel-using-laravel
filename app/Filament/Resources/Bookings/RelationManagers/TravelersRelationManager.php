<?php

namespace App\Filament\Resources\Bookings\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Actions\DeleteAction;
use Filament\Schemas\Components\Grid;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Manage booking travelers.
 */
class TravelersRelationManager extends RelationManager
{
    protected static string $relationship = 'travelers';

    /**
     * Build the travelers form.
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
                        Select::make('traveler_type')
                            ->options([
                                'adult' => 'Adult',
                                'child' => 'Child',
                                'infant' => 'Infant',
                            ])
                            ->required(),
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(100),
                        DatePicker::make('date_of_birth'),
                        Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ]),
                        TextInput::make('nationality')
                            ->maxLength(100),
                        TextInput::make('passport_number')
                            ->maxLength(50),
                        DatePicker::make('passport_expiry'),
                        TextInput::make('emergency_contact_name')
                            ->maxLength(120),
                        TextInput::make('emergency_contact_phone')
                            ->maxLength(40),
                    ]),
                Textarea::make('medical_conditions')
                    ->rows(3)
                    ->columnSpanFull(),
                ]);
    }

    /**
     * Build the travelers table.
     *
     * @param Table $table
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('traveler_type')
                    ->badge(),
                TextColumn::make('first_name')
                    ->label('First name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Last name')
                    ->searchable(),
                TextColumn::make('nationality')
                    ->toggleable(),
                TextColumn::make('passport_number')
                    ->toggleable(isToggledHiddenByDefault: true),
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
