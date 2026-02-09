<?php

namespace App\Filament\Resources\Projects\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class ProjectDetails extends ViewProject
{
    protected static ?string $navigationLabel = 'Detalhes';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::ListBullet;
    protected string $view = 'filament.resources.projects.pages.project-details';
}
