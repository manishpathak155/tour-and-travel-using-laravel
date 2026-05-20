<?php

namespace App\Filament\Resources\Bookings\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Manage booking add-ons.
 */
class AddonsRelationManager extends RelationManager
{
    protected static string $relationship = 'addons';

    /**
     * Build the add-ons table.
     *
     * @param Table $table
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('pivot.quantity')
                    ->label('Qty'),
                TextColumn::make('pivot.price_at_booking')
                    ->label('Price'),
            ]);
    }
}
