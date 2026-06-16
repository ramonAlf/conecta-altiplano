<?php

namespace App\Filament\Resources\CoverageZones\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Schema\Builder;

class CoverageZonesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('coverage_type')
                    ->label('Tipo de cobertura')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('node')
                    ->label('Nodo o torre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('plans_count')
                    ->label('Planes')
                    ->counts('plans')
                    ->sortable(),
                TextColumn::make('technicians_count')
                    ->label('Técnicos')
                    ->counts('technicians')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('is_active')
                    ->label('¿Está activo?')
                    ->toggle()
                    ->query(fn (Builder $query) => $query->where('is_active', true)),
                SelectFilter::make('plans')->relationship('plans', 'name')->multiple()->preload()
                    ->label('Planes'),
                SelectFilter::make('technicians')->relationship('technicians', 'name')->multiple()->preload()
                    ->label('Técnicos'),
            ])
            ->recordActions([
                ViewAction::make()->hiddenLabel(),
                EditAction::make()->hiddenLabel(),
                DeleteAction::make()->hiddenLabel(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
