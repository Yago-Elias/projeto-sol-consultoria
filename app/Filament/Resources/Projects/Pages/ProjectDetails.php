<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\Pages\ViewProject;

class ProjectDetails extends ViewProject
{
    public string $activePageTab = 'detalhes';
    protected string $view = 'filament.resources.projects.pages.project-details';
}
