<?php

namespace App\Filament\Resources\BlogCategories\Pages;

use App\Filament\Resources\BlogCategories\BlogCategoryResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit blog category page.
 */
class EditBlogCategory extends EditRecord
{
    protected static string $resource = BlogCategoryResource::class;
}
