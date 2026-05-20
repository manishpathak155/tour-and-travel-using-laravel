<?php

namespace App\Filament\Resources\Sliders\Pages;

use App\Filament\Resources\Sliders\SliderResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * Create a slider.
 */
class CreateSlider extends CreateRecord
{
    protected static string $resource = SliderResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
