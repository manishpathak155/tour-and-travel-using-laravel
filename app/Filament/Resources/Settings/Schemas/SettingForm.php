<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

/**
 * Defines the settings form schema.
 */
class SettingForm
{
    /**
     * Configure the settings form.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required(),
                TextInput::make('group')
                    ->maxLength(100),
                Textarea::make('value')
                    ->columnSpanFull(),
            ]);
    }
}
