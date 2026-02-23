<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class ProjectConsultantCostWidget extends TableWidget
{
    public ?Project $record = null;

    protected static bool $isDiscovered = false;

    protected const MONTHLY_HOURS = 176;

    protected static ?string $heading = 'Custo por Consultor';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->records(function () {
                if (!$this->record) return collect();

                $project = $this->record->load([
                    'collaborators',
                    'tasks:id,project_id,assigned_to,predicted_hours',
                ]);

                return $project->collaborators->map(function (User $user) use ($project) {
                    $user->total_hours = $project->tasks
                        ->where('assigned_to', $user->id)
                        ->sum('predicted_hours');
                    return $user;
                });
            })
            ->columns([
                TextColumn::make('name')
                    ->label('Consultor')
                    ->searchable(),
                TextColumn::make('total_hours')
                    ->label('Horas Trabalhadas')
                    ->suffix(' h')
                    ->numeric()
                    ->default(0),
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
