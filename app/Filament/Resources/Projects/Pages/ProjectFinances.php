<?php

namespace App\Filament\Resources\Projects\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class ProjectFinances extends ViewProject
{
    protected static ?string $navigationLabel = 'Financeiro';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedBanknotes;
    protected string $view = 'filament.resources.projects.pages.project-finances';
}
