<?php

namespace App\Filament\Resources\Tours\Tables;

use App\Models\Tour;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ReplicateAction;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Defines the tours table schema.
 */
class ToursTable
{
    /**
     * Configure the tours table.
     *
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection('thumbnail')
                    ->label('Image')
                    ->circular(),
                TextColumn::make('title')
                    ->description(fn (Tour $record): ?string => $record->destination?->name)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('difficulty_level')
                    ->label('Difficulty')
                    ->formatStateUsing(fn (Tour $record): string => $record->difficulty_level?->label() ?? 'N/A')
                    ->badge()
                    ->color(fn (Tour $record): string => $record->difficulty_level?->color() ?? 'gray'),
                TextColumn::make('duration_days')
                    ->label('Days')
                    ->sortable(),
                TextColumn::make('base_price_adult')
                    ->label('Price')
                    ->formatStateUsing(fn (Tour $record): string => $record->getFormattedPriceAttribute())
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_best_seller')
                    ->label('Best seller')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('total_bookings')
                    ->label('Bookings')
                    ->sortable(),
                TextColumn::make('average_rating')
                    ->label('Rating')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('destination_id')
                    ->label('Destination')
                    ->relationship('destination', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('difficulty_level')
                    ->label('Difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'moderate' => 'Moderate',
                        'moderate_strenuous' => 'Moderate - Strenuous',
                        'strenuous' => 'Strenuous',
                        'extreme' => 'Extreme',
                    ]),
                SelectFilter::make('tour_type')
                    ->label('Tour type')
                    ->options([
                        'group' => 'Group',
                        'private' => 'Private',
                        'solo' => 'Solo',
                        'guaranteed' => 'Guaranteed',
                    ]),
                TernaryFilter::make('is_published')
                    ->label('Published'),
                TernaryFilter::make('is_best_seller')
                    ->label('Best seller'),
                TernaryFilter::make('is_guaranteed_departure')
                    ->label('Guaranteed departure'),
                Filter::make('price_range')
                    ->form([
                        TextInput::make('min_price')
                            ->label('Min price')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('max_price')
                            ->label('Max price')
                            ->numeric()
                            ->minValue(0),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['min_price'] ?? null, function (Builder $query, $value): Builder {
                                return $query->where('base_price_adult', '>=', $value);
                            })
                            ->when($data['max_price'] ?? null, function (Builder $query, $value): Builder {
                                return $query->where('base_price_adult', '<=', $value);
                            });
                    }),
                Filter::make('duration_range')
                    ->form([
                        TextInput::make('min_days')
                            ->label('Min days')
                            ->numeric()
                            ->minValue(1),
                        TextInput::make('max_days')
                            ->label('Max days')
                            ->numeric()
                            ->minValue(1),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['min_days'] ?? null, function (Builder $query, $value): Builder {
                                return $query->where('duration_days', '>=', $value);
                            })
                            ->when($data['max_days'] ?? null, function (Builder $query, $value): Builder {
                                return $query->where('duration_days', '<=', $value);
                            });
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('toggle_publish')
                    ->label(fn (Tour $record): string => $record->is_published ? 'Unpublish' : 'Publish')
                    ->color(fn (Tour $record): string => $record->is_published ? 'gray' : 'success')
                    ->requiresConfirmation()
                    ->action(function (Tour $record): void {
                        $record->update([
                            'is_published' => ! $record->is_published,
                        ]);
                    }),
                Action::make('preview')
                    ->label('Preview')
                    ->url(fn (Tour $record): string => url('/tours/' . $record->slug), true),
                ReplicateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('publish')
                        ->label('Publish')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_published' => true]);
                        })
                        ->requiresConfirmation(),
                    BulkAction::make('unpublish')
                        ->label('Unpublish')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_published' => false]);
                        })
                        ->requiresConfirmation(),
                    BulkAction::make('feature')
                        ->label('Feature')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_featured' => true]);
                        })
                        ->requiresConfirmation(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
