<?php

namespace App\Filament\Resources\Plans\Tables;

use App\Models\Plan;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class PlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label('Orden')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->label('Nombre')
                    ->sortable(),
                TextColumn::make('price')
                    ->money('MXN')
                    ->label('Precio')
                    ->sortable(),
                TextColumn::make('speed')
                    ->suffix(' Mbps.')
                    ->label('Velocidad')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tipo')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('¿Está activo?')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->label('Creado el')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->label('Actualizado el')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('special_price')
                    ->money('MXN')
                    ->label('Precio especial')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->filters([
                Filter::make('is_active')
                    ->label('¿Está activo?')
                    ->toggle()
                    ->query(fn (Builder $query) => $query->where('is_active', true)),
                Filter::make('special_price')
                    ->label('¿Tiene precio especial?')
                    ->toggle()
                    ->query(fn (Builder $query) => $query->whereNotNull('special_price')),
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        Plan::TYPE_RESIDENTIAL => 'Residencial',
                        Plan::TYPE_BUSINESS => 'Empresarial',
                        Plan::TYPE_ENTERPRISE => 'Empresarial (Enterprise)',
                    ])
                    ->query(function (Builder $query, $data) {
                        if (! empty($data['value'])) {
                            $query->where('type', $data['value']);
                        }
                    }),
            ])
            ->reorderable('order')
            ->recordActions([
                EditAction::make()->hiddenLabel(),
                DeleteAction::make()->hiddenLabel(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('switchActive')
                        ->label('Activar/Desactivar')
                        ->icon(Heroicon::ArrowPath)
                        ->requiresConfirmation()
                        ->modalHeading('Activar/Desactivar planes')
                        ->modalDescription(function (Collection $records): HtmlString {
                            $list = $records
                                ->map(fn (Plan $plan): string => '<li>'.e($plan->name).' ('.($plan->is_active ? 'activo' : 'inactivo').')</li>')
                                ->implode('');

                            return new HtmlString(
                                '<p>¿Confirmas cambiar el estado de los siguientes planes?</p><ul class="list-disc pl-5">'.$list.'</ul>'
                            );
                        })
                        ->modalSubmitActionLabel('Sí, cambiar estado')
                        ->action(function (Collection $records): void {
                            $records->each(fn (Plan $record) => $record->update(['is_active' => ! $record->is_active]));
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
