<?php

namespace App\Livewire;

use App\Filament\Resources\Projects\Pages\ViewProject;
use App\Models\Board;
use App\Models\Project;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\SelectAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

class CriarQuadro extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Project $project;
    public string $filterUser;

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
                    ->required()
            ])
            ->modalWidth('md')
            ->mutateDataUsing(function (array $data) {
                $data['project_id'] = $this->project['id'];
                return $data;
            })
            ->model(Board::class)
            ->after(function () {
                $this->redirect("/projects/{$this->project['id']}");
            });
    }

    public function updatedFilterUser($user)
    {
        $this->dispatch('user-filter', user: $user);
    }
}
