<?php

namespace App\Filament\Resources\Sliders\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Defines the sliders table schema.
 */
class SlidersTable
{
    /**
     * Configure the sliders table.
     *
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('image')
                    ->label('Image')
                    ->limit(40)
                    ->url(fn ($record): string => asset('storage/' . $record->image), true),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('video_url')
                    ->label('Video')
                    ->boolean()
                    ->getStateUsing(fn (?string $state): bool => ! empty($state)),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Sort')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
