<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use App\Permissions;
use Filament\Resources\Pages\ListRecords;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.listing-projects';

    public $projects;

    public function mount(): void
    {
        $user = filament()->auth()->user();

        if ($user['profile']['global_access'] ||
            $user['profile']['manage_projects'] & Permissions::LIST) {
            $this->projects = Project::with([
                    'manager:id,name',
                ])
                ->get(['id', 'name', 'description', 'end_date', 'manager_id']);
        }
        else {
            $this->projects = $user['managedProjects']->merge($user['projects']);
        }
    }

    public function getViewData(): array
    {
        return [
            'projects' => $this->projects,
        ];
    }
}
