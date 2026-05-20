<?php

namespace App\Filament\Resources\TourCategories\Schemas;

use App\Models\TourCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

/**
 * Defines the tour category form schema.
 */
class TourCategoryForm
{
    /**
     * Configure the tour category form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Category details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live()
                                    ->afterStateUpdated(function (?string $state, Set $set): void {
                                        if ($state) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                                TextInput::make('slug')
                                    ->maxLength(255)
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(TourCategory::class, 'slug', ignoreRecord: true)
                                    ->helperText('Auto-generated from the name.'),
                                Select::make('parent_id')
                                    ->label('Parent category')
                                    ->relationship('parent', 'name')
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('icon')
                                    ->maxLength(100),
                                TextInput::make('color')
                                    ->label('Color (hex)')
                                    ->maxLength(7)
                                    ->placeholder('#0D1B4B'),
                                TextInput::make('sort_order')
                                    ->label('Sort order')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                            ]),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
