<?php

namespace App\Filament\Resources\Plans\Schemas;

use App\Models\Plan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PlansForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('is_active')
                    ->label('¿Está activo?')
                    ->default(true)
                    ->columnSpanFull()
                    ->required(),
                Grid::make(3)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->required(),
                        TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->suffix('MXN')
                            ->label('Precio')
                            ->required(),
                        TextInput::make('speed')
                            ->numeric()
                            ->suffix('Mbps.')
                            ->label('Velocidad')
                            ->required(),
                    ]),
                Textarea::make('description')
                    ->label('Descripción')
                    ->columnSpanFull(),
                ToggleButtons::make('type')
                    ->label('Tipo')
                    ->options([
                        Plan::TYPE_RESIDENTIAL => 'Residencial',
                        Plan::TYPE_BUSINESS => 'Empresarial',
                        Plan::TYPE_ENTERPRISE => 'Empresarial (Enterprise)',
                    ])
                    ->inline()
                    ->columnSpanFull()
                    ->required(),
                Toggle::make('has_special_price')
                    ->label('¿Tiene precio especial?')
                    ->default(false)
                    ->saved(false)
                    ->live()
                    ->afterStateHydrated(function (Toggle $component, ?bool $state, ?Plan $record): void {
                        $component->state(filled($record?->special_price));
                    })
                    ->afterStateUpdated(function (Set $set, $state) {
                        if (! $state) {
                            $set('special_price', null);
                            $set('special_price_start_date', null);
                            $set('special_price_end_date', null);
                        }
                    }),
                Grid::make(3)
                    ->dehydratedWhenHidden()
                    ->hidden(fn(Get $get): bool => ! $get('has_special_price'))
                    ->columnSpanFull()

                    ->schema([
                        DatePicker::make('special_price_start_date')
                            ->required(fn(Get $get): bool => $get('has_special_price'))
                            ->label('Fecha de inicio de precio especial'),
                        DatePicker::make('special_price_end_date')
                            ->required(fn(Get $get): bool => $get('has_special_price'))
                            ->label('Fecha de fin de precio especial'),
                        TextInput::make('special_price')
                            ->numeric()
                            ->prefix('$')
                            ->required(fn(Get $get): bool => $get('has_special_price'))
                            ->label('Precio especial'),
                    ]),
            ]);
    }
}
