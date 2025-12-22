<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Resources\Pages\ListRecords;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.listing-projects';

    public $projects;

    public function mount(): void
    {
        $this->projects = Project::with([
                'manager:id,name',
            ])
            ->get(['id', 'name', 'description', 'end_date', 'manager_id']);
    }

    public function getViewData(): array
    {
        return [
            'projects' => $this->projects,
        ];
    }
}
