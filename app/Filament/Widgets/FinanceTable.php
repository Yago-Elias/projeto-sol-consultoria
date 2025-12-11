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
}
