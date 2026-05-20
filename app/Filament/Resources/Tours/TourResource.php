<?php

namespace App\Filament\Resources\Tours;

use App\Filament\Resources\Tours\Pages\CreateTour;
use App\Filament\Resources\Tours\Pages\EditTour;
use App\Filament\Resources\Tours\Pages\ListTours;
use App\Filament\Resources\Tours\RelationManagers\SchedulesRelationManager;
use App\Filament\Resources\Tours\Schemas\TourForm;
use App\Filament\Resources\Tours\Tables\ToursTable;
use App\Models\Tour;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

/**
 * Filament resource for tours.
 */
class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static string|UnitEnum|null $navigationGroup = 'Tour Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static ?string $recordTitleAttribute = 'title';

    /**
     * Build the resource form schema.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return TourForm::configure($schema);
    }

    /**
     * Build the resource table schema.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return ToursTable::configure($table);
    }

    /**
     * Get the resource relations.
     *
     * @return array<int, mixed>
     */
    public static function getRelations(): array
    {
        return [
            SchedulesRelationManager::class,
        ];
    }

    /**
     * Get the resource pages.
     *
     * @return array<string, mixed>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListTours::route('/'),
            'create' => CreateTour::route('/create'),
            'edit' => EditTour::route('/{record}/edit'),
        ];
    }

    /**
     * Get the navigation badge count.
     *
     * @return string|null
     */
    public static function getNavigationBadge(): ?string
    {
        $count = Tour::query()->where('is_published', false)->count();

        return $count > 0 ? (string) $count : null;
    }
}
