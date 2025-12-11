<?php

namespace App\Filament\Widgets;

use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class ProgressChart extends ChartWidget
{
    protected ?string $heading = 'Andamento dos Projetos';
    protected array $projetos = [95, 80, 70, 50, 30, 15, 35, 20];
    protected array $labels = ['Projeto 1', 'Projeto 2', 'Projeto 3', 'Projeto 4', 'Projeto 5', 'Projeto 6', 'Projeto 7', 'Projeto 8'];

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Progresso',
                    'data' => $this->projetos,
                    'barThickness' => 20,
                    'borderWidth' => 0,
                    'backgroundColor' => 'rgba(167, 112, 34, 0.8)'
                ],
            ],
            'labels' => $this->labels,
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
                            callback: (value) => value + '%',
                        },
                        grid: {
                            display: true
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => context.dataset.label + ': ' + context.parsed.y + '%',
                        },
                    },
                    legend: {
                        display: false
                    }
                },
            }
        JS);
    }
}
