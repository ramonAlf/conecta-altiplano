<?php

namespace App\Filament\Resources\CoverageZones\Schemas;

use Fahiem\FilamentPinpoint\PinpointEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CoverageZoneInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombre'),
                TextEntry::make('coverage_type')
                    ->label('Tipo de cobertura'),
                TextEntry::make('plans.name')
                    ->label('Planes')
                    ->badge(),
                TextEntry::make('technicians.name')
                    ->label('Técnicos')
                    ->badge(),
                TextEntry::make('node')
                    ->label('Nodo o torre'),
                IconEntry::make('is_active')
                    ->label('¿Está activo?')
                    ->boolean(),
                Section::make('Ubicación y cobertura')
                    ->columnSpanFull()
                    ->schema([
                        PinpointEntry::make('location')
                            ->latField('center_lat')
                            ->lngField('center_lng')
                            ->radiusField('radius_meters')
                            ->label('Ubicación'),
                        TextEntry::make('radius_meters')
                            ->label('Radio de cobertura')
                            ->suffix('m'),
                    ]),
            ]);
    }
}
