<?php

namespace App\Filament\Widgets;

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

        $lateProjects = $projects->where('end_date', '<', now())->count();

        $dangeredProjects = 0;

        foreach ($projects as $project)
            $dangeredProjects += $project['tasks']->where('due_date', '<', now(), 'and')->where('status', 'PENDENTE')->count() > 0;

        return [
            Stat::make('Projetos', count($projects))
                ->description('Total de projetos ativos')
                ->icon(Heroicon::Folder),
            Stat::make('Tarefas Concluídas', $percentage . '%')
                ->description('Porcentagem de tarefas concluídas')
                ->icon(Heroicon::CheckCircle),
            Stat::make('Lucro Médio', 'R$ 00,00')
                ->description('Lucro médio dos projetos')
                ->icon(Heroicon::ArrowTrendingUp),
            Stat::make('Atrasados', $lateProjects)
                ->description('Total de projetos atrasados')
                ->icon(Heroicon::ExclamationCircle),
            Stat::make('Risco de Atraso', $dangeredProjects)
                ->description('Total de projetos com tarefas atrasadas')
                ->icon(Heroicon::ExclamationTriangle),
        ];
    }
}
