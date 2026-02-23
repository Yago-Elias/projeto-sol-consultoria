<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Models\Task;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Components\RenderHook;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

class TasksRelationManager extends RelationManager
{
    #[Url(as: 'consultor')]
    public ?string $activeTab = null;
    public ?string $status = null;
    protected static string $relationship = 'tasks';
    protected static ?string $label = 'tarefa';
    protected string $view = 'livewire.task-board';

    public function mount(?string $status = null): void
    {
        $this->status = $status;
        parent::mount();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
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
                                ->where('project_id', $this->ownerRecord['id'])
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
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns([
                        'sm' => 3
                    ])
                    ->heading(fn (Task $record): string => $record['assignedTo']['name'])
                    ->headerActions([
                        Action::make('avatar')
                            ->icon(fn (Task $record): string => filament()->getUserAvatarUrl($record['assignedTo']))
                            ->url(fn (Task $record): string => '/users/' . $record['assigned_to'], true)
                            ->extraAttributes([
                                'class' => '[clip-path:circle(50%_at_50%_50%)] rounded-full border border-(--neutro-3)'
                            ], true)
                            ->iconButton()
                            ->iconSize(IconSize::TwoExtraLarge),
                        EditAction::make()
                            ->icon(Heroicon::OutlinedPencil)
                            ->extraAttributes([
                                'class' => 'bg-primary-200 rounded-full border border-primary-600'
                            ])
                            ->modelLabel('tarefa')
                            ->hidden(fn (Task $task) => auth()->user()->cannot('update', $task))
                            ->iconButton(),
                        DeleteAction::make()
                            ->icon(Heroicon::OutlinedTrash)
                            ->extraAttributes([
                                'class' => 'bg-danger-200 rounded-full border border-danger-600'
                            ])
                            ->modelLabel('tarefa')
                            ->cancelParentActions()
                            ->hidden(fn (Task $task) => auth()->user()->cannot('delete', $task))
                            ->iconButton(),
                    ])
                    ->components([
                        TextEntry::make('predicted_hours')
                            ->label('Duração da tarefa')
                            ->numeric()
                            ->icon(Heroicon::OutlinedClock)
                            ->formatStateUsing(fn (string $state): string => $state . ' horas'),
                        TextEntry::make('due_date')
                            ->label('Prazo de conclusão')
                            ->icon(Heroicon::OutlinedCalendar)
                            ->date(),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(function (Task $task) {
                                if ($task['status'] === 'APROVADA') {
                                    return 'success';
                                }
                                if ($task['status'] === 'EM_APROVACAO') {
                                    return 'warning';
                                }
                                if ($task['due_date'] < now()) {
                                    return 'danger';
                                }
                                return 'gray';
                            })
                            ->formatStateUsing(function (string $state, Task $task) {
                                if ($state === 'APROVADA') {
                                    return 'Concluída';
                                }
                                if ($state === 'EM_APROVACAO') {
                                    return 'Esperando Aprovação';
                                }
                                if ($task['due_date'] < now()) {
                                    return 'Atrasada';
                                }
                                return 'Pendente';
                            }),
                        TextEntry::make('description')
                            ->label('Descrição')
                            ->placeholder('-')
                            ->icon(Heroicon::OutlinedBars3BottomLeft)
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->label('Data de Criação')
                            ->icon(Heroicon::OutlinedCalendar)
                            ->date(),
                        TextEntry::make('conclusion_date')
                            ->label('Data de conclusão')
                            ->icon(Heroicon::OutlinedCalendar)
                            ->date()
                            ->hidden(fn (Task $task) => $task['status'] === 'PENDENTE' || $task['status'] === 'EM_PROGRESSO'),
                        TextEntry::make('conclusion_message')
                            ->label('Mensagem de conclusão')
                            ->placeholder('-')
                            ->icon(Heroicon::OutlinedBars3BottomLeft)
                            ->hidden(fn (Task $task) => $task['status'] === 'PENDENTE' || $task['status'] === 'EM_PROGRESSO')
                            ->columnSpanFull(),
                    ])
                    ->footerActions([
                    ])
                    ->contained(false)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('due_date')
            ->modifyQueryUsing(function (Builder $query) {
                if (isset($this->status)) {
                    $query = $query->where('status', $this->status);
                }

                return $query;
            })
            ->heading(function () {
                if ($this->status === 'PENDENTE') {
                    return 'Pendentes';
                }
                if ($this->status === 'EM_PROGRESSO') {
                    return 'Em progresso';
                }
                if ($this->status === 'EM_APROVACAO') {
                    return 'Esperando aprovação';
                }
                return 'Concluídas';
            })
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->wrap()
                    ->icon(function (Task $task) {
                        if ($task['status'] === 'PENDENTE' && $task['due_date'] < now()) {
                            return Heroicon::OutlinedExclamationCircle;
                        }
                        if ($task['status'] === 'EM_APROVACAO') {
                            return Heroicon::OutlinedClock;
                        }
                        return Heroicon::OutlinedCheckCircle;
                    })
                    ->iconColor(function (Task $task) {
                        if ($task['status'] === 'APROVADA') {
                            return 'success';
                        }
                        if ($task['status'] === 'EM_APROVACAO') {
                            return 'warning';
                        }
                        if ($task['due_date'] >= now()) {
                            return 'gray';
                        }
                        return 'danger';
                    })
                    ->description(function (Task $task) {
                        if ($task['status'] !== 'APROVADA') {
                            return 'Até ' . date_format($task['due_date'], 'd/m/Y');
                        }
                        return null;
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalHeading(fn (?Task $record) => $record['title'] ?? '')
                    ->modalCancelAction(false)
                    ->icon(fn (?Task $record): string => filament()->getUserAvatarUrl($record['assignedTo']) ?? null)
                    ->extraAttributes([
                        'class' => '[clip-path:circle(50%_at_50%_50%)] rounded-full border border-(--neutro-3)'
                    ], true)
                    ->iconButton()
                    ->closeModalByClickingAway()
                    ->iconSize(IconSize::TwoExtraLarge),
            ])
            ->emptyStateHeading('Sem Tarefas')
            ->paginated(false)
            ->searchable(false)
            ->selectable(false)
            ->extraAttributes([
                'class' => 'hide-header'
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }

    public function getTabs(): array
    {
        $tabs = ['all' => Tab::make('Todos')];

        foreach ($this->ownerRecord['collaborators'] as $user) {
            $tabs[$user['name']] = Tab::make($user['name'])
                ->modifyQueryUsing(fn (Builder $query) => $query->where('assigned_to', $user['id']));
        }

        return $tabs;
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                RenderHook::make(PanelsRenderHook::RESOURCE_RELATION_MANAGER_BEFORE),
                EmbeddedTable::make(),
                RenderHook::make(PanelsRenderHook::RESOURCE_RELATION_MANAGER_AFTER),
            ]);
    }

    #[On('user-filter')]
    public function userFilter($user): void
    {
        $this->activeTab = $user;
    }

    #[On('refresh-tables')]
    public function refreshTable(): void
    {
        $this->dispatch('$refresh');
    }

    public function openTask(string $task)
    {
        $this->mountAction('view', ['record' => $task]);
    }

    public function receiveTask(int $id): void
    {
        $task = $this->ownerRecord->tasks->findOrFail($id);
        $canMove = true;

        if ($this->status === 'APROVADA') {
            if ($task['status'] !== 'EM_APROVACAO') {
                $canMove = false;
                Notification::make()
                    ->title('Erro')
                    ->body('A tarefe precisa ser aprovada')
                    ->danger()
                    ->send();
            }
            else if (auth()->user()->cannot('approve', $task)) {
                $canMove = false;
                Notification::make()
                    ->title('Erro')
                    ->body('Você não tem permissão de fazer isso!')
                    ->danger()
                    ->send();
            }
        }
        else if ($task['status'] === 'PENDENTE' &&
                 auth()->user()->cannot('start', $task) &&
                 auth()->user()->cannot('conclude', $task)) {
            $canMove = false;
            Notification::make()
                ->title('Erro')
                ->body('Você não tem permissão de fazer isso!')
                ->danger()
                ->send();
        }
        else if ($task->status === 'APROVADA' && auth()->user()->cannot('approve', $task) ||
                 $this->status === 'EM_APROVACAO' && auth()->user()->cannot('conclude', $task)) {
            $canMove = false;
            Notification::make()
                ->title('Erro')
                ->body('Você não tem permissão de fazer isso!2')
                ->danger()
                ->send();
        }

        if ($canMove) {
            if ($this->status === 'EM_APROVACAO') {
                $this->mountTableAction('conclusionAction', $task->id);
            }

            $task->status = $this->status;
            $task->save();
        }

        $this->dispatch('refresh-tables');
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('conclusion')
                ->label('Concluir Tarefa')
                ->icon(Heroicon::OutlinedCheck)
                ->schema([
                    TextEntry::make('description')
                        ->label('Descrição')
                        ->placeholder('-')
                        ->icon(Heroicon::OutlinedBars3BottomLeft)
                        ->columnSpanFull(),
                    TextInput::make('message')
                        ->label('Mensagem de Conclusão')
                        ->columnSpanFull()
                ])
                ->action(function (array $data, Task $record) {
                    $record['status'] = 'EM_APROVACAO';
                    $record['conclusion_date'] = now();
                    $record['conclusion_message'] = $data['message'];

                    $record->save();
                })
                ->after(function () {
                    $this->dispatch('refresh-tables');
                })
                ->cancelParentActions()
//                ->hidden(true),
        ];
    }
}
