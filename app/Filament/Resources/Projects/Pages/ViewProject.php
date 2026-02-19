<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;
    protected string $view = 'filament.resources.projects.pages.list-tasks';
    protected static ?string $navigationLabel = 'Tarefas';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedTableCells;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('progress-bar')
                ->view('filament.resources.projects.partials.circle-progress')
                ->viewData([
                    'percentage' => $this->record->progress,
                    'endDate' => $this->record['end_date']
                ]),
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return $this->record['name'];
    }
}
