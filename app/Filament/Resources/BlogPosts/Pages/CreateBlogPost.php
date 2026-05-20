<?php

namespace App\Filament\Resources\BlogPosts\Pages;

use App\Filament\Resources\BlogPosts\BlogPostResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Create a blog post.
 */
class CreateBlogPost extends CreateRecord
{
    protected static string $resource = BlogPostResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
