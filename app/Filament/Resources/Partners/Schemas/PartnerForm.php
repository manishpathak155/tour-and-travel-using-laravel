<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Defines the partner form schema.
 */
class PartnerForm
{
    /**
     * Configure the partner form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Partner details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('website_url')
                                    ->label('Website URL')
                                    ->url()
                                    ->maxLength(500),
                                Select::make('partner_type')
                                    ->options([
                                        'booking_platform' => 'Booking platform',
                                        'media' => 'Media',
                                        'gear' => 'Gear',
                                        'affiliate' => 'Affiliate',
                                    ])
                                    ->required(),
                                TextInput::make('sort_order')
                                    ->label('Sort order')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                                FileUpload::make('logo')
                                    ->label('Logo')
                                    ->image()
                                    ->imageResizeMode('contain')
                                    ->imageResizeTargetWidth(1200)
                                    ->imageResizeTargetHeight(1200)
                                    ->imageResizeUpscale(false)
                                    ->disk('public')
                                    ->directory('partners')
                                    ->visibility('public')
                                    ->maxSize(2048),
                            ]),
                    ]),
            ]);
    }
}
