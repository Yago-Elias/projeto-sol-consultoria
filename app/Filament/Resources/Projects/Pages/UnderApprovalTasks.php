<?php

namespace App\Filament\Resources\Projects\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class UnderApprovalTasks extends ViewProject
{
    protected static ?string $navigationLabel = 'Aprovação';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedClock;
    protected string $view = 'filament.resources.projects.pages.under-approval-tasks';
}
