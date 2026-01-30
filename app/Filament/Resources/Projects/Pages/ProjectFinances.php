<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use BackedEnum;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ProjectFinances extends ViewRecord
{
    protected static string $resource = ProjectResource::class;
    protected static ?string $navigationLabel = 'Financeiro';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedBanknotes;
    protected string $view = 'filament.resources.projects.pages.project-finances';
}
