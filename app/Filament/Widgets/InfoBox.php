<?php

namespace App\Filament\Widgets;

use App\Models\FinancialEntry;
use App\Models\Project;
use App\Models\Task;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InfoBox extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;
    protected function getStats(): array
    {
        $projects = Project::query()->get();
        $tasks = Task::query()->get();

        $totalTasks = $tasks->count();
        $approvedTasks = $tasks->where('status', 'APROVADA')->count();
        $percentage = $totalTasks > 0 ? round($approvedTasks / $totalTasks * 100, 1) : 0;

        $avgProfit = FinancialEntry::query()
                ->whereNotNull('payment_date')
                ->get()
                ->avg(fn (FinancialEntry $entry) =>
                    $entry['total_amount'] * ($entry['financialType']['type'] === 'Expense' ? -1 : 1)) ?? 0;

        $lateProjects = $projects->where('end_date', '<', now())->count();

        $dangeredProjects = 0;
        foreach ($projects as $project) {
            $dangeredProjects += $project['tasks']->where('due_date', '<', now(), 'and')->where('status', 'PENDENTE')->count() > 0;
        }

        return [
            Stat::make('Projetos', count($projects))
                ->description('Total de projetos ativos')
                ->icon(Heroicon::OutlinedFolder),
            Stat::make('Tarefas Concluídas', $percentage . '%')
                ->description('Porcentagem de tarefas concluídas')
                ->icon(Heroicon::OutlinedCheckCircle),
            Stat::make('Lucro Médio', 'R$ ' . round($avgProfit, 2))
                ->description('Lucro médio dos projetos')
                ->icon(Heroicon::OutlinedArrowTrendingUp),
            Stat::make('Atrasados', $lateProjects)
                ->description('Total de projetos atrasados')
                ->icon(Heroicon::OutlinedExclamationCircle),
            Stat::make('Risco de Atraso', $dangeredProjects)
                ->description('Total de projetos com tarefas atrasadas')
                ->icon(Heroicon::OutlinedExclamationTriangle),
        ];
    }
}
