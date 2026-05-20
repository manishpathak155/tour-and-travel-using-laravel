<?php

namespace App\Filament\Resources\BlogPosts\Tables;

use App\Models\BlogPost;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

/**
 * Defines the blog posts table schema.
 */
class BlogPostsTable
{
    /**
     * Configure the blog posts table.
     *
     * @param Table $table
     * @return Table
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('post_type')
                    ->label('Type')
                    ->badge()
                    ->formatStateUsing(fn (BlogPost $record): string => $record->post_type === 'travel_guide' ? 'Travel Guide' : 'Blog')
                    ->color(fn (BlogPost $record): string => $record->post_type === 'travel_guide' ? 'info' : 'gray'),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable(),
                TextColumn::make('is_published')
                    ->label('Published')
                    ->badge()
                    ->formatStateUsing(fn (BlogPost $record): string => $record->is_published ? 'Yes' : 'No')
                    ->color(fn (BlogPost $record): string => $record->is_published ? 'success' : 'gray'),
                TextColumn::make('view_count')
                    ->label('Views')
                    ->sortable(),
                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('post_type')
                    ->label('Type')
                    ->options([
                        'blog' => 'Blog',
                        'travel_guide' => 'Travel Guide',
                    ]),
                TernaryFilter::make('is_published')
                    ->label('Published'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
