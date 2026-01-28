<?php

namespace App\Livewire;

use App\Filament\Resources\Projects\Pages\ViewProject;
use App\Models\Board;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Livewire\Component;

class CriarQuadro extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public int $projectId;

    public function render()
    {
        return view('livewire.criar-quadro');
    }

    public function createAction(): Action
    {
        return CreateAction::make()
            ->label('Criar Quadro')
            ->schema([
                TextInput::make('name')
                    ->label('Nome do Quadro')
            ])
            ->modalWidth('md')
            ->mutateDataUsing(function (array $data) {
                $data['project_id'] = $this->projectId;
                return $data;
            })
            ->model(Board::class)
            ->after(function () {
                $this->redirect("/projects/{$this->projectId}");
            });
    }
}
