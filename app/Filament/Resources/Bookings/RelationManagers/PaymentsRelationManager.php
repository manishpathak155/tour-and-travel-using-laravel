<?php

namespace App\Filament\Resources\Bookings\RelationManagers;

use Filament\Forms\Components\DateTimePicker;
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
 * Manage booking payments.
 */
class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    /**
     * Build the payments form.
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
                        TextInput::make('payment_reference')
                            ->required()
                            ->maxLength(50),
                        Select::make('gateway')
                            ->options([
                                'stripe' => 'Stripe',
                                'paypal' => 'PayPal',
                                'khalti' => 'Khalti',
                                'esewa' => 'eSewa',
                                'bank_transfer' => 'Bank Transfer',
                                'cash' => 'Cash',
                                'other' => 'Other',
                            ])
                            ->required(),
                        TextInput::make('gateway_transaction_id')
                            ->maxLength(255),
                        TextInput::make('amount')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                        TextInput::make('currency')
                            ->maxLength(3)
                            ->default('USD'),
                        Select::make('payment_type')
                            ->options([
                                'deposit' => 'Deposit',
                                'full' => 'Full',
                                'installment' => 'Installment',
                                'refund' => 'Refund',
                            ])
                            ->required(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'completed' => 'Completed',
                                'failed' => 'Failed',
                                'cancelled' => 'Cancelled',
                                'refunded' => 'Refunded',
                            ])
                            ->required(),
                        DateTimePicker::make('paid_at'),
                    ]),
                Textarea::make('notes')
                    ->rows(3)
                    ->columnSpanFull(),
                ]);
    }

    /**
     * Build the payments table.
     *
     * @param Table $table
     * @return Table
     */
    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('payment_reference')
                    ->label('Reference')
                    ->searchable(),
                TextColumn::make('gateway')
                    ->badge(),
                TextColumn::make('amount')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('paid_at')
                    ->dateTime(),
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
