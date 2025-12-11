<?php

namespace App\Filament\Widgets;

use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class ProgressChart extends ChartWidget
{
//    protected ?string $heading = 'Andamento dos Projetos';

    protected function getData(): array
    {
        $projetos = [95, 80, 70, 50, 30, 15, 35, 20];
        $labels = ['Projeto 1', 'Projeto 2', 'Projeto 3', 'Projeto 4', 'Projeto 5', 'Projeto 6', 'Projeto 7', 'Projeto 8'];

        return [
            'datasets' => [
                [
                    'label' => 'Progresso',
                    'data' => $projetos,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): RawJs {
        return RawJs::make(<<<JS
            {
                indexAxis: 'y',
                scales: {
                    x: {
                        ticks: {
                            callback: (value) => value + '%', // Adds '%' to Y-axis labels
                        },
                    },
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => context.dataset.label + ': ' + context.parsed.y + '%', // Adds '%' to tooltip
                        },
                    },
                },
            }
        JS);
    }
}
