<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class ProjectConsultantCostWidget extends TableWidget
{
    public ?int $projectId = null;

    protected const MONTHLY_HOURS = 176;

    protected static ?string $heading = 'Custo por Consultor';

    public function table(Table $table): Table
    {
        return $table
            ->records(function () {
                // if (!$this->projectId) return collect();

                return Project::find($this->projectId)
                    ->collaborators();
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Consultor')
                    ->searchable(),
                TextColumn::make('total_hours')
                    ->label('Horas Trabalhadas')
                    ->suffix(' h')
                    ->numeric()
                    ->default(0)
                    ->summarize(
                        Sum::make()->label('Total de Horas')->suffix(' h')
                    ),
                TextColumn::make('valor_hora')
                    ->label('Valor/hora')
                    ->state(fn (User $record) =>
                        number_format($record->salary / self::MONTHLY_HOURS, 2, ',', '.')
                    )
                    ->prefix('R$ '),
                TextColumn::make('custo_total')
                    ->label('Custo Total')
                    ->state(fn (User $record) =>
                        number_format(
                            ($record->total_hours ?? 0) * ($record->salary / self::MONTHLY_HOURS),
                            2, ',', '.'
                        )
                    )
                    ->prefix('R$ ')
                    ->color('danger'),
                // TextColumn::make('debug')
                //     ->label(function (?User $record) {
                //         dump($record);
                //         return 'teste';
                //     })
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
