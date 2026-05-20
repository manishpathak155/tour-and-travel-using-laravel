<?php

namespace App\Filament\Resources\TourCategories\Pages;

use App\Filament\Resources\TourCategories\TourCategoryResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit tour category page.
 */
class EditTourCategory extends EditRecord
{
    protected static string $resource = TourCategoryResource::class;
}
