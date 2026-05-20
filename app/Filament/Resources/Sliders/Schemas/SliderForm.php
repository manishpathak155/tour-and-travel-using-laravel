<?php

namespace App\Filament\Resources\Sliders\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Slider as RangeSlider;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Defines the slider form schema.
 */
class SliderForm
{
    /**
     * Configure the slider form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Slide content')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->maxLength(255),
                                TextInput::make('subtitle')
                                    ->maxLength(255),
                                TextInput::make('cta_text')
                                    ->label('CTA text')
                                    ->maxLength(100),
                                TextInput::make('cta_url')
                                    ->label('CTA URL')
                                    ->url()
                                    ->maxLength(500),
                                TextInput::make('video_url')
                                    ->label('Video URL (MP4)')
                                    ->url()
                                    ->maxLength(500),
                                TextInput::make('sort_order')
                                    ->label('Sort order')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                                RangeSlider::make('overlay_opacity')
                                    ->label('Overlay opacity')
                                    ->minValue(0)
                                    ->maxValue(1)
                                    ->step(0.05)
                                    ->default(0.4),
                            ]),
                        Textarea::make('description')
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth(2000)
                            ->imageResizeTargetHeight(2000)
                            ->imageResizeUpscale(false)
                            ->disk('public')
                            ->directory('sliders')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->required(),
                    ]),
            ]);
    }
}
