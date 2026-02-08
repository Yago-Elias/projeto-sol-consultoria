<?php

namespace App\Filament\Resources\Projects\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class Revenue extends StatsOverviewWidget
{
    public ?Model $record = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Receita', '12.2k'),
        ];
    }
}
