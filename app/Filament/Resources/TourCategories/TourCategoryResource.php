<?php

namespace App\Filament\Resources\TourCategories;

use App\Filament\Resources\TourCategories\Pages\CreateTourCategory;
use App\Filament\Resources\TourCategories\Pages\EditTourCategory;
use App\Filament\Resources\TourCategories\Pages\ListTourCategories;
use App\Filament\Resources\TourCategories\Schemas\TourCategoryForm;
use App\Filament\Resources\TourCategories\Tables\TourCategoriesTable;
use App\Models\TourCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

/**
 * Filament resource for tour categories.
 */
class TourCategoryResource extends Resource
{
    protected static ?string $model = TourCategory::class;

    protected static string|UnitEnum|null $navigationGroup = 'Tour Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * Build the resource form schema.
     *
     * @param Schema $schema
     * @return Schema
     */
    public static function form(Schema $schema): Schema
    {
        return TourCategoryForm::configure($schema);
    }

    /**
     * Build the resource table schema.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return TourCategoriesTable::configure($table);
    }

    /**
     * Get the resource pages.
     *
     * @return array<string, mixed>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListTourCategories::route('/'),
            'create' => CreateTourCategory::route('/create'),
            'edit' => EditTourCategory::route('/{record}/edit'),
        ];
    }
}
