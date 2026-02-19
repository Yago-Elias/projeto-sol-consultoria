<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected string $view = 'filament.resources.projects.pages.listing-projects';

    public $search = '';

    public int $perPage = 8;

    public function getProjects(): LengthAwarePaginator
    {
        $query = Project::query()
            ->with('tasks')
            ->select(['id', 'name', 'description', 'end_date', 'manager_id']);

        if ($this->search) {
            $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        return $query->paginate($this->perPage);
    }

    public function countProjects(): int
    {
        return Project::query()->count();
    }
}
