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
    public string $activePageTab = 'tarefas';

    protected function getHeaderActions(): array
    {
        $total = count($this->record['tasks']);
        $status = $this->record['tasks']->groupBy('status');
        $percentage = $total > 0 ? 100 * count($status['APROVADA']) / $total : 0;

        return [
            Action::make('progress-bar')
                ->view('filament.resources.projects.partials.circle-progress')
                ->viewData([
                    'percentage' => $percentage,
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
            'urls' => [
                'tarefas' => ProjectResource::getUrl('view', ['record' => $this->record]),
                'aprovacao' => ProjectResource::getUrl('aprovacao', ['record' => $this->record]),
                'financeiro' => ProjectResource::getUrl('financeiro', ['record' => $this->record]),
                'detalhes' => ProjectResource::getUrl('detalhes', ['record' => $this->record])
            ]
        ];
    }
}
