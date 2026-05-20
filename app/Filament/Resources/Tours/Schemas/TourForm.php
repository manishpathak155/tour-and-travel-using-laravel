<?php

namespace App\Filament\Resources\Tours\Schemas;

use App\Enums\DifficultyLevel;
use App\Enums\TourType;
use App\Models\Tour;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

/**
 * Defines the tour form schema.
 */
class TourForm
{
    /**
     * Configure the tour form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make('Tour')
                    ->tabs([
                        Tabs\Tab::make('Basic Info')
                            ->schema([
                                Section::make('Trip Overview')
                                    ->schema([
                                        Hidden::make('created_by')
                                            ->default(fn (): ?int => auth()->id())
                                            ->dehydrated(),
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('title')
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
                                                    ->unique(Tour::class, 'slug', ignoreRecord: true)
                                                    ->helperText('Auto-generated from the title.'),
                                                Select::make('destination_id')
                                                    ->label('Destination')
                                                    ->relationship('destination', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
                                                Select::make('category_id')
                                                    ->label('Category')
                                                    ->relationship('category', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
                                                TextInput::make('trip_grade')
                                                    ->label('Trip grade')
                                                    ->maxLength(100),
                                                TextInput::make('activities')
                                                    ->label('Activities')
                                                    ->maxLength(255),
                                                Select::make('difficulty_level')
                                                    ->options(self::enumOptions(DifficultyLevel::cases()))
                                                    ->required(),
                                                Select::make('tour_type')
                                                    ->options(self::enumOptions(TourType::cases()))
                                                    ->required(),
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
                                Section::make('Trip Highlights')
                                    ->schema([
                                        Repeater::make('highlights')
                                            ->label('Highlights')
                                            ->simple(
                                                TextInput::make('value')
                                                    ->label('Highlight item')
                                                    ->placeholder('Enter one highlight')
                                            )
                                            ->reorderable()
                                            ->addActionLabel('Add highlight'),
                                    ]),
                            ]),
                        Tabs\Tab::make('Pricing & Dates')
                            ->schema([
                                Section::make('Pricing')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('base_price_adult')
                                                    ->label('Base price (adult)')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->prefix('US$')
                                                    ->helperText('Amount in paisa.'),
                                                TextInput::make('original_price_adult')
                                                    ->label('Original price (adult)')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->prefix('US$')
                                                    ->helperText('Amount in paisa.'),
                                                TextInput::make('base_price_child')
                                                    ->label('Base price (child)')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->prefix('US$')
                                                    ->helperText('Amount in paisa.'),
                                                TextInput::make('base_price_infant')
                                                    ->label('Base price (infant)')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->prefix('US$')
                                                    ->helperText('Amount in paisa.'),
                                                TextInput::make('private_tour_price')
                                                    ->label('Private tour price')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->prefix('US$')
                                                    ->helperText('Amount in paisa.'),
                                                Select::make('currency')
                                                    ->options([
                                                        'USD' => 'USD',
                                                        'NPR' => 'NPR',
                                                        'EUR' => 'EUR',
                                                        'GBP' => 'GBP',
                                                    ]),
                                                TextInput::make('deposit_percentage')
                                                    ->label('Deposit percentage')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->default(30)
                                                    ->suffix('%'),
                                                Select::make('cancellation_policy')
                                                    ->options([
                                                        'free' => 'Free',
                                                        'moderate' => 'Moderate',
                                                        'strict' => 'Strict',
                                                        'non_refundable' => 'Non-refundable',
                                                    ]),
                                                TextInput::make('cancellation_hours')
                                                    ->label('Cancellation hours')
                                                    ->numeric()
                                                    ->minValue(0),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Trip Details')
                            ->schema([
                                Section::make('Trip Facts')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('duration_days')
                                                    ->numeric()
                                                    ->minValue(1),
                                                TextInput::make('duration_nights')
                                                    ->numeric()
                                                    ->minValue(0),
                                                TextInput::make('max_altitude_meters')
                                                    ->label('Max altitude (m)')
                                                    ->numeric()
                                                    ->minValue(0),
                                                TextInput::make('min_group_size')
                                                    ->numeric()
                                                    ->minValue(1),
                                                TextInput::make('max_group_size')
                                                    ->numeric()
                                                    ->minValue(1),
                                                TextInput::make('min_age')
                                                    ->numeric()
                                                    ->minValue(0),
                                                TextInput::make('max_age')
                                                    ->numeric()
                                                    ->minValue(0),
                                                TextInput::make('starts_city')
                                                    ->maxLength(100),
                                                TextInput::make('ends_city')
                                                    ->maxLength(100),
                                                TextInput::make('best_time')
                                                    ->maxLength(100),
                                                TagsInput::make('languages_offered')
                                                    ->label('Languages offered'),
                                                TextInput::make('meeting_point')
                                                    ->maxLength(255),
                                                TextInput::make('meeting_point_lat')
                                                    ->label('Meeting point latitude')
                                                    ->numeric(),
                                                TextInput::make('meeting_point_lng')
                                                    ->label('Meeting point longitude')
                                                    ->numeric(),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Inclusions & Exclusions')
                            ->schema([
                                Section::make('Cost details')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                RichEditor::make('cost_includes')
                                                    ->label('Cost includes'),
                                                RichEditor::make('cost_excludes')
                                                    ->label('Cost excludes'),
                                            ]),
                                    ]),
                                Section::make('Quick lists')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Repeater::make('inclusions')
                                                    ->simple(TextInput::make('value')
                                                        ->label('Inclusion')),
                                                Repeater::make('exclusions')
                                                    ->simple(TextInput::make('value')
                                                        ->label('Exclusion')),
                                                Repeater::make('what_to_bring')
                                                    ->simple(TextInput::make('value')
                                                        ->label('What to bring')),
                                                Repeater::make('gear_list')
                                                    ->simple(TextInput::make('value')
                                                        ->label('Gear item')),
                                            ]),
                                    ]),
                            ]),
                        Tabs\Tab::make('Itinerary Builder')
                            ->schema([
                                Repeater::make('itineraries')
                                    ->relationship()
                                    ->orderColumn('day_number')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('day_number')
                                                    ->numeric()
                                                    ->required(),
                                                TextInput::make('title')
                                                    ->required()
                                                    ->maxLength(255),
                                                TextInput::make('walking_hours')
                                                    ->numeric(),
                                                TextInput::make('distance_km')
                                                    ->numeric(),
                                                TextInput::make('max_altitude_meters')
                                                    ->numeric(),
                                                TextInput::make('accommodation')
                                                    ->maxLength(255),
                                                Select::make('accommodation_type')
                                                    ->options([
                                                        'teahouse' => 'Teahouse',
                                                        'lodge' => 'Lodge',
                                                        'hotel' => 'Hotel',
                                                        'camping' => 'Camping',
                                                        'luxury' => 'Luxury',
                                                        'guesthouse' => 'Guesthouse',
                                                    ]),
                                                TextInput::make('transport')
                                                    ->maxLength(100),
                                            ]),
                                        TagsInput::make('meals_included')
                                            ->label('Meals included'),
                                        RichEditor::make('description')
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('Route Map')
                            ->schema([
                                Repeater::make('routePoints')
                                    ->relationship()
                                    ->orderColumn('sort_order')
                                    ->schema([
                                        Grid::make(4)
                                            ->schema([
                                                TextInput::make('day_number')
                                                    ->numeric(),
                                                TextInput::make('place_name')
                                                    ->maxLength(255),
                                                TextInput::make('latitude')
                                                    ->numeric(),
                                                TextInput::make('longitude')
                                                    ->numeric(),
                                                TextInput::make('altitude_meters')
                                                    ->numeric(),
                                                TextInput::make('sort_order')
                                                    ->numeric()
                                                    ->default(0),
                                            ]),
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('Essential Info')
                            ->schema([
                                Repeater::make('essential_info')
                                    ->schema([
                                        TextInput::make('title')
                                            ->maxLength(160),
                                        RichEditor::make('body')
                                            ->label('Content')
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('Reviews & Socials')
                            ->schema([
                                Section::make('Review platforms')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('tripadvisor_url')
                                                    ->label('TripAdvisor URL')
                                                    ->url()
                                                    ->maxLength(500),
                                                TextInput::make('tripadvisor_review_count')
                                                    ->label('TripAdvisor review count')
                                                    ->numeric()
                                                    ->minValue(0),
                                                TextInput::make('google_review_count')
                                                    ->label('Google review count')
                                                    ->numeric()
                                                    ->minValue(0),
                                                TextInput::make('trustpilot_review_count')
                                                    ->label('Trustpilot review count')
                                                    ->numeric()
                                                    ->minValue(0),
                                            ]),
                                    ]),
                                Section::make('Video reviews')
                                    ->schema([
                                        Repeater::make('videoReviews')
                                            ->relationship()
                                            ->orderColumn('sort_order')
                                            ->schema([
                                                TextInput::make('youtube_url')
                                                    ->label('YouTube URL')
                                                    ->maxLength(500),
                                                TextInput::make('reviewer_name')
                                                    ->label('Reviewer name')
                                                    ->maxLength(100),
                                                TextInput::make('title')
                                                    ->label('Title')
                                                    ->maxLength(255),
                                                TextInput::make('sort_order')
                                                    ->numeric()
                                                    ->default(0),
                                            ])
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tabs\Tab::make('Media')
                            ->schema([
                                Section::make('Images')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('thumbnail')
                                            ->collection('thumbnail')
                                            ->image()
                                            ->imageResizeMode('cover')
                                            ->imageResizeTargetWidth(2000)
                                            ->imageResizeTargetHeight(1500)
                                            ->imageResizeUpscale(false),
                                        SpatieMediaLibraryFileUpload::make('gallery')
                                            ->collection('gallery')
                                            ->image()
                                            ->imageResizeMode('contain')
                                            ->imageResizeTargetWidth(2400)
                                            ->imageResizeTargetHeight(1600)
                                            ->imageResizeUpscale(false)
                                            ->multiple()
                                            ->reorderable(),
                                        SpatieMediaLibraryFileUpload::make('brochure')
                                            ->collection('brochure')
                                            ->acceptedFileTypes(['application/pdf']),
                                    ]),
                            ]),
                        Tabs\Tab::make('Publish & Badges')
                            ->schema([
                                Section::make('Status')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Toggle::make('is_published')
                                                    ->label('Published'),
                                                Toggle::make('is_active')
                                                    ->label('Active'),
                                                Toggle::make('is_featured')
                                                    ->label('Featured'),
                                                Toggle::make('is_best_seller')
                                                    ->label('Best seller'),
                                                Toggle::make('is_guaranteed_departure')
                                                    ->label('Guaranteed departure'),
                                                TextInput::make('badge_text')
                                                    ->label('Badge text')
                                                    ->maxLength(50),
                                                DateTimePicker::make('published_at')
                                                    ->label('Published at'),
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
                                        TagsInput::make('meta_keywords')
                                            ->label('Meta keywords'),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    /**
     * Build enum options for select inputs.
     *
     * @param array<int, \BackedEnum> $cases
     * @return array<string, string>
     */
    private static function enumOptions(array $cases): array
    {
        $options = [];

        foreach ($cases as $case) {
            $options[$case->value] = method_exists($case, 'label') ? $case->label() : $case->value;
        }

        return $options;
    }
}
