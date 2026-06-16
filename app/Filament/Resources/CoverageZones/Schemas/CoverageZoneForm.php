<?php

namespace App\Filament\Resources\CoverageZones\Schemas;

use App\CoverageType;
use Fahiem\FilamentPinpoint\Pinpoint;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CoverageZoneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Select::make('coverage_type')
                    ->label('Tipo de cobertura')
                    ->native(false)
                    ->options(CoverageType::class)
                    ->required(),
                Select::make('plans')
                    ->label('Planes')
                    ->relationship('plans', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),
                Select::make('technicians')
                    ->label('Técnicos')
                    ->relationship('technicians', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('node')
                    ->label('Nodo o torre')
                    ->required(),
                Toggle::make('is_active')
                    ->label('¿Está activo?')
                    ->default(true)
                    ->required(),
                Section::make('Ubicación y cobertura')
                    ->columnSpanFull()
                    ->schema([
                        Pinpoint::make('location')
                            ->latField('center_lat')
                            ->lngField('center_lng')
                            ->draggable()
                            ->searchable()
                            ->radiusField('radius_meters')
                            ->dehydrated(false),
                        Hidden::make('center_lat'),
                        Hidden::make('center_lng'),
                        TextInput::make('radius_meters')
                            ->numeric()
                            ->live(debounce: 300)
                            ->suffix('m')
                            ->minValue(50)
                            ->helperText('Radio aproximado de cobertura desde la torre.'),
                    ]),
            ]);
    }
}
