<?php

namespace App\Filament\Resources\Destinations\Schemas;

use App\Models\Destination;
use App\Support\DestinationLocationOptions;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

/**
 * Defines the destination form schema.
 */
class DestinationForm
{
    /**
     * Configure the destination form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make('Destination')
                    ->tabs([
                        Tabs\Tab::make('Overview')
                            ->schema([
                                Section::make('Basics')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Hidden::make('continent')
                                                    ->default('Asia')
                                                    ->dehydrated(),
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
                                                    ->unique(Destination::class, 'slug', ignoreRecord: true)
                                                    ->helperText('Auto-generated from the name.'),
                                                Select::make('country')
                                                    ->required()
                                                    ->options(DestinationLocationOptions::countries())
                                                    ->searchable()
                                                    ->live()
                                                    ->afterStateUpdated(function (?string $state, Set $set): void {
                                                        $set('state', null);
                                                        $set('region', null);
                                                        $set('zone', null);
                                                        $set('district', null);
                                                    }),
                                                TextInput::make('state')
                                                    ->label('State')
                                                    ->maxLength(150)
                                                    ->visible(fn (Get $get): bool => filled($get('country')) && $get('country') !== 'Nepal'),
                                                TextInput::make('region')
                                                    ->label('Region')
                                                    ->maxLength(150)
                                                    ->visible(fn (Get $get): bool => filled($get('country')) && $get('country') !== 'Nepal'),
                                                Select::make('zone')
                                                    ->label('Zone')
                                                    ->options(DestinationLocationOptions::zones())
                                                    ->searchable()
                                                    ->live()
                                                    ->visible(fn (Get $get): bool => $get('country') === 'Nepal')
                                                    ->required(fn (Get $get): bool => $get('country') === 'Nepal')
                                                    ->afterStateUpdated(function (?string $state, Set $set): void {
                                                        $set('district', null);
                                                    }),
                                                Select::make('district')
                                                    ->label('District')
                                                    ->options(fn (Get $get): array => DestinationLocationOptions::districts($get('zone')))
                                                    ->searchable()
                                                    ->visible(fn (Get $get): bool => $get('country') === 'Nepal')
                                                    ->required(fn (Get $get): bool => $get('country') === 'Nepal')
                                                    ->disabled(fn (Get $get): bool => blank($get('zone')))
                                                    ->helperText('Select a zone first.'),
                                                TextInput::make('city')
                                                    ->maxLength(150),
                                            ]),
                                        Textarea::make('short_description')
                                            ->label('Short description')
                                            ->rows(3)
                                            ->maxLength(500)
                                            ->required()
                                            ->columnSpanFull(),
                                        RichEditor::make('description')
                                            ->required()
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tabs\Tab::make('Details')
                            ->schema([
                                Section::make('Highlights')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('best_season')
                                                    ->maxLength(255),
                                                TextInput::make('local_currency')
                                                    ->maxLength(10),
                                                TextInput::make('language')
                                                    ->maxLength(100),
                                                TextInput::make('time_zone')
                                                    ->maxLength(50),
                                            ]),
                                        Textarea::make('climate_info')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        Toggle::make('visa_required')
                                            ->label('Visa required'),
                                        Textarea::make('visa_info')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tabs\Tab::make('Status')
                            ->schema([
                                Section::make('Visibility')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Toggle::make('is_featured')
                                                    ->label('Featured'),
                                                Toggle::make('is_active')
                                                    ->label('Active')
                                                    ->default(true),
                                                TextInput::make('sort_order')
                                                    ->numeric()
                                                    ->default(0),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('SEO')
                            ->schema([
                                Section::make('Metadata')
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta title')
                                            ->maxLength(255),
                                        Textarea::make('meta_description')
                                            ->label('Meta description')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        Textarea::make('meta_keywords')
                                            ->label('Meta keywords')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
