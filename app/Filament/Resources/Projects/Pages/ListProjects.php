<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use App\Permissions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.listing-projects';

    public $search = '';

    public int $perPage = 8;

    protected $query;

    public function getProjects(): LengthAwarePaginator
    {
        $this->query = Project::query()
            ->with('tasks')
            ->select(['id', 'name', 'description', 'end_date', 'manager_id']);
        $user = filament()->auth()->user();

        if (!$user['profile']['global_access'] &&
            !($user['profile']['manage_projects'] & Permissions::LIST_ALL_PROJECTS)) {
            $user_projects = $user['managedProjects']->merge($user['projects'])->pluck('id');
            $this->query->whereIn('id', $user_projects);
        }

        if ($this->search) {
            $this->query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%");
                });
        }

        return $this->query->paginate($this->perPage);
    }

    public function countProjects(): int
    {
        return $this->query->count();
    }
}
