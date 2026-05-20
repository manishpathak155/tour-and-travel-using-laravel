<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Defines the FAQ form schema.
 */
class FaqForm
{
    /**
     * Configure the FAQ form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('FAQ')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('tour_id')
                                    ->label('Tour')
                                    ->relationship('tour', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Global FAQ'),
                                TextInput::make('faq_category')
                                    ->label('Category')
                                    ->maxLength(100),
                                TextInput::make('sort_order')
                                    ->label('Sort order')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                            ]),
                        TextInput::make('question')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        RichEditor::make('answer')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
