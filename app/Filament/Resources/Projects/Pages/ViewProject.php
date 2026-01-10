<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Concerns\HasTabs;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class ViewProject extends ViewRecord
{
    use HasTabs;

    protected static string $resource = ProjectResource::class;

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

    public function getTabs(): array
    {
        return [
            'tarefas' => Tab::make('Tarefas'),
            'aprovacao' => Tab::make('Em Aprovação'),
            'financeiro' => Tab::make('Financeiro'),
            'detailhes' => Tab::make('Detalhes'),
        ];
    }

    public function content(Schema $schema): Schema
    {
        $content = [];
        return $schema
            ->components([
                $this->getTabsContentComponent()
            ]);
    }
}
