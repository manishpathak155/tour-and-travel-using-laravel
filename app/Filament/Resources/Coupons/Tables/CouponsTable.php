<?php

namespace App\Filament\Resources\Coupons\Tables;

use App\Models\Coupon;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

/**
 * Defines the coupons table schema.
 */
class CouponsTable
{
    /**
     * Configure the coupons table.
     *
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('discount_type')
                    ->label('Discount')
                    ->formatStateUsing(function (Coupon $record): string {
                        $value = $record->discount_value;

                        if ($record->discount_type === 'percentage') {
                            return $value . '%';
                        }

                        return 'US$ ' . number_format($value / 100, 0);
                    })
                    ->sortable(),
                TextColumn::make('valid_from')
                    ->label('Valid from')
                    ->dateTime(),
                TextColumn::make('valid_until')
                    ->label('Valid until')
                    ->dateTime(),
                TextColumn::make('current_uses')
                    ->label('Uses')
                    ->formatStateUsing(fn (Coupon $record): string => $record->current_uses . '/' . ($record->max_uses ?? '∞')),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
                ReplicateAction::make(),
                Action::make('deactivate')
                    ->label('Deactivate')
                    ->requiresConfirmation()
                    ->visible(fn (Coupon $record): bool => $record->is_active)
                    ->action(fn (Coupon $record): bool => $record->update(['is_active' => false])),
                DeleteAction::make(),
            ])
            ->defaultSort('valid_until', 'desc');
    }
}
