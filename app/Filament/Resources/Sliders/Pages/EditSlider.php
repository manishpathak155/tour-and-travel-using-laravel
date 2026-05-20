<?php

namespace App\Filament\Resources\Sliders\Pages;

use App\Filament\Resources\Sliders\SliderResource;
use Filament\Resources\Pages\EditRecord;

/**
 * Edit a slider.
 */
class EditSlider extends EditRecord
{
    protected static string $resource = SliderResource::class;

    protected \Filament\Support\Enums\Width|string|null $maxContentWidth = 'full';
}
