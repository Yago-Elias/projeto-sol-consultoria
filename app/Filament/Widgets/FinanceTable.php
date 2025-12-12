<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class FinanceTable extends Widget
{
    protected string $view = 'filament.widgets.finance-table';

    public static function getSort(): int
    {
        return 2;
    }

    protected function getViewData(): array
    {
        return [
            ['1 semana', 'R$ 00,00', 'R$ 00,00', 'R$ 00,00'],
            ['1 semana', 'R$ 00,00', 'R$ 00,00', 'R$ 00,00'],
            ['1 semana', 'R$ 00,00', 'R$ 00,00', 'R$ 00,00'],
            ['1 semana', 'R$ 00,00', 'R$ 00,00', 'R$ 00,00'],
            ['1 semana', 'R$ 00,00', 'R$ 00,00', 'R$ 00,00'],
            ['1 semana', 'R$ 00,00', 'R$ 00,00', 'R$ 00,00'],
            ['1 semana', 'R$ 00,00', 'R$ 00,00', 'R$ 00,00'],
            ['1 semana', 'R$ 00,00', 'R$ 00,00', 'R$ 00,00'],
        ];
    }
}
