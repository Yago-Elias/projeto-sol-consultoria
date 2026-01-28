<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Models\Board;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\HeaderActionsPosition;
use Filament\Tables\Grouping\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TasksRelationManager extends RelationManager
{
    public Board $board;
    protected static string $relationship = 'tasks';

    public function mount($board = null): void
    {
        $this->board = $board;
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
                    ->relationship('assignedTo', 'name',
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
                            ->iconButton(),
                        DeleteAction::make()
                            ->icon(Heroicon::OutlinedTrash)
                            ->extraAttributes([
                                'class' => 'bg-danger-200 rounded-full border border-danger-600'
                            ])
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
                                if ($task['status'] === 'APROVADA')
                                    return 'success';
                                if ($task['status'] === 'EM_APROVACAO')
                                    return 'warning';
                                return 'gray';
                            })
                            ->formatStateUsing(fn (string $state): string => str_replace('_', ' ', $state)),
                        TextEntry::make('description')
                            ->label('Descrição')
                            ->placeholder('-')
                            ->icon(Heroicon::OutlinedBars3BottomLeft)
                            ->columnSpanFull(),
                        TextEntry::make('conclusion_date')
                            ->label('Data de conclusão')
                            ->icon(Heroicon::OutlinedCalendar)
                            ->date()
                            ->hidden(fn (Task $task) => $task['status'] !== 'APROVADA'),
                        TextEntry::make('conclusion_message')
                            ->label('Mensagem de conclusão')
                            ->placeholder('-')
                            ->icon(Heroicon::OutlinedBars3BottomLeft)
                            ->hidden(fn (Task $task) => $task['status'] !== 'APROVADA')
                            ->columnSpanFull(),
                    ])
                    ->footerActions([
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
                                    ->hidden(fn (Task $record) => filament()->auth()->id() !== $record['assigned_to'])
                                    ->columnSpanFull()
                            ])
                            ->action(function (array $data, Task $record) {
                                $record['status'] = 'EM_APROVACAO';
                                $record['conclusion_date'] = now();
                                $record['conclusion_message'] = $data['message'];

                                $record->save();
                            })
                            ->hidden(fn (Task $record) =>
                                filament()->auth()->id() !== $record['assigned_to'] ||
                                $record['status'] !== 'PENDENTE')
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
                if (isset($this->board))
                    return $query
                            ->where('board_id', $this->board['id']);
                return $query;
            })
            ->heading($this->board['name'])
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->wrap()
                    ->icon(function (Task $task) {
                        if ($task['status'] === 'ATRASADA')
                            return Heroicon::OutlinedExclamationCircle;
                        if ($task['status'] === 'EM_APROVACAO')
                            return Heroicon::OutlinedClock;
                        return Heroicon::OutlinedCheckCircle;
                    })
                    ->iconColor(function (Task $task) {
                        if ($task['status'] === 'PENDENTE')
                            return 'gray';
                        if ($task['status'] === 'EM_APROVACAO')
                            return 'warning';
                        if ($task['status'] === 'APROVADA')
                            return 'success';
                        return 'danger';
                    })
                    ->description(function (Task $task) {
                        if ($task['status'] !== 'APROVADA' && $task['status'] !== 'FINALIZADA_COM_ATRASO')
                            return 'Até ' . date_format($task['due_date'], 'd/m/Y');
                        return null;
                    }),
            ])
            ->groups([
                Group::make('status')
                    ->getTitleFromRecordUsing(function (Task $task) {
                        if ($task['status'] === 'ATRASADA' || $task['status'] === 'PENDENTE')
                            return 'Pendentes';
                        if ($task['status'] === 'FINALIZADA_COM_ATRASO' || $task['status'] === 'APROVADA')
                            return 'Concluídas';
                        return 'Em Aprovação';
                    })
                    ->titlePrefixedWithLabel(false)
                    ->collapsible()
            ])
            ->defaultGroup('status')
            ->groupingSettingsHidden()
            ->headerActions([
                CreateAction::make()
                    ->modalHeading('Nova Tarefa')
                    ->mutateDataUsing(function (array $data): array {
                        $data['board_id'] = $this->board['id'];

                        return $data;
                    })
                    ->icon(Heroicon::OutlinedPlus)
                    ->extraAttributes([
                        'class' => 'bg-primary-900 rounded-full border border-primary-100 text-primary-100'
                    ])
                    ->iconButton(),
                EditAction::make('edit')
                    ->modalHeading('Editar quadro')
                    ->modalWidth('md')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome do quadro')
                    ])
                    ->after(function (array $data, Board $record, $livewire) {
                        $record['name'] = $data['name'];
                        $record->save();
                        $livewire->resetTable();
                    })
                    ->record($this->board)
                    ->icon(Heroicon::OutlinedPencil)
                    ->extraAttributes([
                        'class' => 'bg-primary-200 rounded-full border border-primary-600 text-primary-600'
                    ])
                    ->iconButton(),
                DeleteAction::make('delete')
                    ->record($this->board)
                    ->before(function (Board $record) {
                        $record['tasks']->each->delete();
                    })
                    ->after(function () {
                        $this->redirect("/projects/{$this->ownerRecord['id']}");
                    })
                    ->modalHeading('Excluir Quadro?')
                    ->modalDescription('Essa ação apagará todas as tarefas do quadro')
                    ->icon(Heroicon::OutlinedTrash)
                    ->extraAttributes([
                        'class' => 'bg-danger-200 rounded-full border border-danger-600 text-danger-600'
                    ])
                    ->iconButton()
            ])
            ->headerActionsPosition(HeaderActionsPosition::Adaptive)
            ->recordActions([
                ViewAction::make()
                    ->modalHeading(fn (Task $record) => $record['title'])
                    ->modalCancelAction(false)
                    ->icon(fn (Task $record): string => filament()->getUserAvatarUrl($record['assignedTo']))
                    ->extraAttributes([
                        'class' => '[clip-path:circle(50%_at_50%_50%)] rounded-full border border-(--neutro-3)'
                    ], true)
                    ->iconButton()
                    ->iconSize(IconSize::TwoExtraLarge),
            ])
            ->toolbarActions([
                Action::make('progress')
                    ->view('filament.resources.projects.partials.progress')
                    ->viewData(function () {
                        $finished = count(array_filter($this->board['tasks']->toarray(),
                            fn ($item) => $item['status'] == 'APROVADA' || $item['status'] == 'FINALIZADA_COM_ATRASO'));
                        $total = count($this->board['tasks']);

                        return [
                            'percent' => $total > 0 ? round(100 * $finished / $total) : 0
                        ];
                    })
            ])
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
}
