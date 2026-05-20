<?php

namespace App\Filament\Resources\Inquiries\Tables;

use App\Models\Inquiry;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

/**
 * Defines the inquiries table schema.
 */
class InquiriesTable
{
    /**
     * Configure the inquiries table.
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
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('tour.title')
                    ->label('Tour')
                    ->toggleable(),
                TextColumn::make('travel_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('group_size')
                    ->label('Group')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (Inquiry $record): string => match ($record->status) {
                        'new' => 'danger',
                        'in_progress' => 'warning',
                        'replied' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'in_progress' => 'In Progress',
                        'replied' => 'Replied',
                        'closed' => 'Closed',
                    ]),
            ])
            ->actions([
                Action::make('reply')
                    ->label('Send Reply')
                    ->form([
                        Textarea::make('reply_message')
                            ->label('Reply message')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function (Inquiry $record): void {
                        $record->update([
                            'status' => 'replied',
                            'replied_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Reply marked as sent')
                            ->success()
                            ->send();
                    }),
                Action::make('assign')
                    ->label('Assign')
                    ->form([
                        Select::make('assigned_to')
                            ->label('Assign to')
                            ->relationship('assignedTo', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->action(function (Inquiry $record, array $data): void {
                        $record->update([
                            'assigned_to' => $data['assigned_to'],
                            'status' => $record->status === 'new' ? 'in_progress' : $record->status,
                        ]);
                    }),
                Action::make('close')
                    ->label('Mark Closed')
                    ->requiresConfirmation()
                    ->action(function (Inquiry $record): void {
                        $record->update([
                            'status' => 'closed',
                        ]);
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
