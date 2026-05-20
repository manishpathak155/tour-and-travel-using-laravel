<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use App\Models\BlogPost;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

/**
 * Defines the blog post form schema.
 */
class BlogPostForm
{
    /**
     * Configure the blog post form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make('Blog')
                    ->tabs([
                        Tabs\Tab::make('Content')
                            ->schema([
                                Section::make('Main Content')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('author_id')
                                                    ->label('Author')
                                                    ->relationship('author', 'name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required(),
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
                                                    ->unique(BlogPost::class, 'slug', ignoreRecord: true)
                                                    ->helperText('Auto-generated from the title.'),
                                                Select::make('post_type')
                                                    ->label('Type')
                                                    ->options([
                                                        'blog' => 'Blog',
                                                        'travel_guide' => 'Travel Guide',
                                                    ])
                                                    ->required(),
                                                TextInput::make('reading_time_minutes')
                                                    ->numeric()
                                                    ->minValue(1),
                                            ]),
                                        Textarea::make('excerpt')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        RichEditor::make('body')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tabs\Tab::make('Media')
                            ->schema([
                                Section::make('Featured Image')
                                    ->schema([
                                        SpatieMediaLibraryFileUpload::make('featured_image')
                                            ->collection('featured')
                                            ->image()
                                            ->imageResizeMode('cover')
                                            ->imageResizeTargetWidth(2000)
                                            ->imageResizeTargetHeight(1500)
                                            ->imageResizeUpscale(false)
                                            ->required(),
                                    ]),
                            ]),
                        Tabs\Tab::make('Categorisation')
                            ->schema([
                                Section::make('Categories & Tags')
                                    ->schema([
                                        Select::make('categories')
                                            ->label('Categories')
                                            ->relationship('categories', 'name')
                                            ->multiple()
                                            ->searchable()
                                            ->preload(),
                                        TagsInput::make('tags')
                                            ->label('Tags'),
                                    ]),
                            ]),
                        Tabs\Tab::make('SEO')
                            ->schema([
                                Section::make('Meta')
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta title')
                                            ->maxLength(255),
                                        Textarea::make('meta_description')
                                            ->label('Meta description')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                        Tabs\Tab::make('Publish')
                            ->schema([
                                Section::make('Publish Settings')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                Toggle::make('is_featured')
                                                    ->label('Featured'),
                                                Toggle::make('is_published')
                                                    ->label('Published'),
                                                DateTimePicker::make('published_at')
                                                    ->label('Published at'),
                                            ]),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
