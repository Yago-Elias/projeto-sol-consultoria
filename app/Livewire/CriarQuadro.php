<?php

namespace App\Livewire;

use App\Filament\Resources\Projects\Pages\ViewProject;
use App\Models\Project;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\SelectAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
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
            ->label('Criar Tarefa')
            ->schema([
                Section::make('task_form')
                    ->columns()
                    ->contained(false)
                    ->heading(null)
                    ->components([
                            TextInput::make('title')
                                ->label('Título')
                                ->required(),
                            Select::make('assigned_to')
                                ->label('Responsável')
                                ->required()
                                ->relationship(
                                    'assignedTo',
                                    'name',
                                    fn (Builder $query) =>
                                        $query
                                            ->join('projects_users', 'user_id', 'id')
                                            ->where('project_id', $this->project->id)
                                )
                                ->searchable()
                                ->preload(),
                            Textarea::make('description')
                                ->label('Descrição')
                                ->columnSpanFull(),
                            TextInput::make('predicted_hours')
                                ->label('Duração da Tarefa')
                                ->required()
                                ->numeric(),
                            DatePicker::make('due_date')
                                ->label('Prazo de Conclusão')
                                ->required(),
                        ])
                    ])
            ->mutateDataUsing(function (array $data) {
                $data['project_id'] = $this->project['id'];

                return $data;
            })
            ->model(Task::class)
            ->modelLabel('tarefa')
            ->after(function () {
                $this->dispatch('refresh-tables');
            });
    }

    public function updatedFilterUser($user)
    {
        $this->dispatch('user-filter', user: $user);
    }
}
