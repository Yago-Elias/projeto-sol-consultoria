<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;
    protected string $view = 'filament.resources.projects.pages.list-tasks';
    protected string $activeTab = 'tasks';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('progress-bar')
                ->view('filament.resources.projects.partials.circle-progress')
                ->viewData([
                    'percentage' => 30,
                    'endDate' => $this->record['end_date']
                ]),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return $this->record['name'];
    }

    protected function getViewData(): array
    {
        return [
            'project' => $this->record,
            'activeTab' => $this->activeTab
        ];
    }
}
