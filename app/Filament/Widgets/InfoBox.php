<?php

namespace App\Filament\Widgets;

use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InfoBox extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Projetos', '8')
                ->description('Total de projetos ativos')
                ->icon(Heroicon::Folder),
            Stat::make('Tarefas Concluídas', '50%')
                ->description('Porcentagem de tarefas concluídas')
                ->icon(Heroicon::CheckCircle),
            Stat::make('Lucro Médio', 'R$ 00,00')
                ->description('Lucro médio dos projetos')
                ->icon(Heroicon::ArrowTrendingUp),
            Stat::make('Atrasados', '0')
                ->description('Total de projetos atrasados')
                ->icon(Heroicon::ExclamationCircle),
            Stat::make('Risco de Atraso', '3')
                ->description('Total de projetos com tarefas atrasadas')
                ->icon(Heroicon::ExclamationTriangle),
        ];
    }
}
