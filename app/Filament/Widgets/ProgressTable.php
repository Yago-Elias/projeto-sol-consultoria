<?php

namespace App\Filament\Widgets;

use App\Filament\Tables\Columns\ProgressBar;
use App\Models\Project;
use App\Models\Task;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProgressTable extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Project::query())
            ->defaultSort('end_date')
            ->heading('Andamento dos Projetos')
            ->columns([
                TextColumn::make('name')
                    ->label('Projeto')
                    ->url(fn (Project $record) => "/projects/{$record['id']}"),
                ProgressBar::make('Progresso')
                    ->viewData(function (Project $record) {
                        $total = $record['tasks']->count();
                        $approved = $record['tasks']->where('status', 'APROVADA')->count();
                        return ['percent' => $total > 0 ? round($approved / $total * 100) : 0];
                    })
                    ->width('25%'),
                TextColumn::make('Tempo restante')
                    ->state(function (Project $record) {
                        if (now() > $record['end_date'])
                            return 'Atrasado';

                        $diff = now()->diff($record['end_date']);

                        if ($diff->y > 0)
                            return $diff->y . ' ano' . ($diff->m > 1 ? 's' : '');
                        if ($diff->m > 0)
                            return $diff->m . ($diff->m > 1 ? ' meses' : ' mês');
                        if ($diff->d > 7)
                            return round($diff->d / 7) . ' semana' . ($diff->d >= 14 ? 's' : '');
                        return $diff->d . ' dia' . ($diff->d > 1 ? 's' : '');
                    }),
                TextColumn::make('Custos')
                    ->state(fn (Project $record) =>
                        'R$ ' . number_format($record['financialEntries']
                            ->whereNotNull('payment_date')
                            ->where('financialType.type', 'Expense')
                            ->sum('total_amount'), 2, ',', '.')
                    )
                    ->color('danger'),
                TextColumn::make('Receita')
                    ->state(fn (Project $record) =>
                        'R$ ' . number_format($record['financialEntries']
                            ->whereNotNull('payment_date')
                            ->where('financialType.type', 'Payment')
                            ->sum('total_amount'), 2, ',', '.')
                    )
                    ->color('success'),
                TextColumn::make('Lucro')
                    ->state(fn (Project $record) =>
                        'R$ ' . number_format($record['financialEntries']
                            ->whereNotNull('payment_date')
                            ->where('financialType.type', 'Payment')
                            ->sum('total_amount') - $record['financialEntries']
                            ->whereNotNull('payment_date')
                            ->where('financialType.type', 'Expense')
                            ->sum('total_amount'), 2, ',', '.')
                    )
            ]);
    }
}
