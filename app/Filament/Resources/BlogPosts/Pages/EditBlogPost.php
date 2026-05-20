<?php

namespace App\Filament\Resources\BlogPosts\Pages;

use App\Filament\Resources\BlogPosts\BlogPostResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit a blog post.
 */
class EditBlogPost extends EditRecord
{
    protected static string $resource = BlogPostResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
