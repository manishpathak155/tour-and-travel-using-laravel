<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

/**
 * Defines the team member form schema.
 */
class TeamMemberForm
{
    /**
     * Configure the team member form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('role')
                                    ->required()
                                    ->maxLength(255),
                                FileUpload::make('photo')
                                    ->label('Photo')
                                    ->image()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth(1200)
                                    ->imageResizeTargetHeight(1200)
                                    ->imageResizeUpscale(false)
                                    ->disk('public')
                                    ->directory('team')
                                    ->visibility('public')
                                    ->maxSize(2048),
                                TextInput::make('sort_order')
                                    ->label('Sort order')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),
                                Toggle::make('is_published')
                                    ->label('Published')
                                    ->default(true),
                            ]),
                        RichEditor::make('bio')
                            ->label('Bio')
                            ->columnSpanFull(),
                    ]),
                Section::make('Social links')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('linkedin_url')
                                    ->label('LinkedIn URL')
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->url()
                                    ->maxLength(255),
                                TextInput::make('facebook_url')
                                    ->label('Facebook URL')
                                    ->url()
                                    ->maxLength(255),
                            ]),
                    ]),
            ]);
    }
}
