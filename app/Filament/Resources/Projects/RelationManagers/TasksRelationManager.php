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
                            ->color('gray')
                            ->formatStateUsing(fn (string $state): string => str_replace('_', ' ', $state)),
                        TextEntry::make('description')
                            ->label('Descrição')
                            ->placeholder('-')
                            ->icon(Heroicon::OutlinedBars3BottomLeft)
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
            ->modifyQueryUsing(function (Builder $query) {
                if (isset($this->board))
                    return $query->where('board_id', $this->board['id']);
                return $query;
            })
            ->heading($this->board['nome'])
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->icon(Heroicon::OutlinedCheckCircle),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                'create' => CreateAction::make()
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
                'edit' => Action::make('edit')
                    ->icon(Heroicon::OutlinedPencil)
                    ->extraAttributes([
                        'class' => 'bg-primary-200 rounded-full border border-primary-600 text-primary-600'
                    ])
                    ->iconButton(),
                'delete' => Action::make('delete')
                    ->icon(Heroicon::OutlinedTrash)
                    ->extraAttributes([
                        'class' => 'bg-danger-200 rounded-full border border-danger-600 text-danger-600'
                    ])
                    ->iconButton()
            ])
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
                        return [
                            'percent' => 50
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
