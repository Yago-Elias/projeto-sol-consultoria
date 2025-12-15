<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.listing-projects';
}
