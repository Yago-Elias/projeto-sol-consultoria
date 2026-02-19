<?php

namespace App\Filament\Resources\Projects\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class UnderApprovalTasks extends ViewProject
{
    protected static ?string $navigationLabel = 'Aprovação';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedClock;
    protected string $view = 'filament.resources.projects.pages.under-approval-tasks';

    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()->can('approveTasks', $parameters['record']);
    }
}
