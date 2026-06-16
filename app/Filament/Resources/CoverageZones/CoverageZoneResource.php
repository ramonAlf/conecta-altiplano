<?php

namespace App\Filament\Resources\CoverageZones;

use App\Filament\Resources\CoverageZones\Pages\CreateCoverageZone;
use App\Filament\Resources\CoverageZones\Pages\EditCoverageZone;
use App\Filament\Resources\CoverageZones\Pages\ListCoverageZones;
use App\Filament\Resources\CoverageZones\Pages\ViewCoverageZone;
use App\Filament\Resources\CoverageZones\Schemas\CoverageZoneForm;
use App\Filament\Resources\CoverageZones\Schemas\CoverageZoneInfolist;
use App\Filament\Resources\CoverageZones\Tables\CoverageZonesTable;
use App\Models\CoverageZone;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CoverageZoneResource extends Resource
{
    protected static ?string $modelLabel = 'zona de cobertura';

    protected static ?string $pluralModelLabel = 'zonas de cobertura';

    protected static ?string $navigationLabel = 'Zonas de cobertura';

    protected static string|UnitEnum|null $navigationGroup = 'Zonas de cobertura';

    protected static ?int $navigationSort = 1;

    protected static ?string $model = CoverageZone::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Wifi;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CoverageZoneForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CoverageZoneInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CoverageZonesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCoverageZones::route('/'),
            'create' => CreateCoverageZone::route('/create'),
            'view' => ViewCoverageZone::route('/{record}'),
            'edit' => EditCoverageZone::route('/{record}/edit'),
        ];
    }
}
