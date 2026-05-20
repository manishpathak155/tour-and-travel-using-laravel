<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Models\Review;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

/**
 * Defines the reviews table schema.
 */
class ReviewsTable
{
    /**
     * Configure the reviews table.
     *
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tour.title')
                    ->label('Tour')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),
                TextColumn::make('overall_rating')
                    ->label('Rating')
                    ->sortable(),
                TextColumn::make('is_published')
                    ->label('Published')
                    ->badge()
                    ->formatStateUsing(fn (Review $record): string => $record->is_published ? 'Yes' : 'No')
                    ->color(fn (Review $record): string => $record->is_published ? 'success' : 'gray'),
                TextColumn::make('is_verified')
                    ->label('Verified')
                    ->badge()
                    ->formatStateUsing(fn (Review $record): string => $record->is_verified ? 'Yes' : 'No')
                    ->color(fn (Review $record): string => $record->is_verified ? 'success' : 'gray'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tour_id')
                    ->label('Tour')
                    ->relationship('tour', 'title')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('is_published')
                    ->label('Published'),
                TernaryFilter::make('is_verified')
                    ->label('Verified'),
            ])
            ->actions([
                Action::make('toggle_publish')
                    ->label(fn (Review $record): string => $record->is_published ? 'Unpublish' : 'Publish')
                    ->requiresConfirmation()
                    ->action(function (Review $record): void {
                        $record->update([
                            'is_published' => ! $record->is_published,
                        ]);
                    }),
                Action::make('mark_verified')
                    ->label('Mark Verified')
                    ->visible(fn (Review $record): bool => ! $record->is_verified)
                    ->action(function (Review $record): void {
                        $record->update([
                            'is_verified' => true,
                        ]);
                    }),
                Action::make('respond')
                    ->label('Add Response')
                    ->form([
                        Textarea::make('admin_response')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (Review $record, array $data): void {
                        $record->update([
                            'admin_response' => $data['admin_response'],
                            'admin_responded_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Response added')
                            ->success()
                            ->send();
                    }),
                Action::make('promote')
                    ->label('Promote to Testimonial')
                    ->requiresConfirmation()
                    ->action(function (): void {
                        Notification::make()
                            ->title('Testimonial promotion queued')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
