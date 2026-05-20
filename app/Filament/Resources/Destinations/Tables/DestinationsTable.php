<?php

namespace App\Filament\Resources\Destinations\Tables;

use App\Models\Destination;
use App\Support\DestinationLocationOptions;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\Schemas\Components\Utilities\Get;

/**
 * Defines the destinations table schema.
 */
class DestinationsTable
{
    /**
     * Configure the destinations table.
     *
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('country')
                    ->sortable(),
                TextColumn::make('state')
                    ->sortable(),
                TextColumn::make('region')
                    ->label('Region')
                    ->sortable(),
                TextColumn::make('zone')
                    ->label('Zone')
                    ->sortable(),
                TextColumn::make('district')
                    ->label('District')
                    ->sortable(),
                TextColumn::make('city')
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('location')
                    ->form([
                        Select::make('zone')
                            ->label('Zone')
                            ->options(DestinationLocationOptions::zones())
                            ->searchable()
                            ->live(),
                        Select::make('district')
                            ->label('District')
                            ->options(fn (Get $get): array => DestinationLocationOptions::districts($get('zone')))
                            ->searchable()
                            ->disabled(fn (Get $get): bool => blank($get('zone')))
                            ->helperText('Select a zone first.'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['zone'] ?? null, fn (Builder $query, $zone): Builder => $query->where('zone', $zone))
                            ->when($data['district'] ?? null, fn (Builder $query, $district): Builder => $query->where('district', $district));
                    }),
                Filter::make('country')
                    ->form([
                        Select::make('country')
                            ->label('Country')
                            ->options(DestinationLocationOptions::countries())
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['country'] ?? null, fn (Builder $query, $country): Builder => $query->where('country', $country));
                    }),
                TernaryFilter::make('is_active')
                    ->label('Active'),
                TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
