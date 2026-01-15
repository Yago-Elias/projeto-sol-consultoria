<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Models\Task;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Image;
use Filament\Schemas\Components\RenderHook;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Support\View\Components\BadgeComponent;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

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
                    ->columns()
                    ->heading(fn (Task $record) =>
                        'Tarefa '. strtolower(str_replace('_', ' ', $record['status'])))
                    ->headerActions([
                        EditAction::make()
                            ->icon(Heroicon::OutlinedPencil)
                            ->iconButton(),
                        DeleteAction::make()
                            ->icon(Heroicon::OutlinedTrash)
                            ->iconButton(),
                    ])
                    ->components([
                        ImageEntry::make('assigned_to')
                            ->state(fn (Task $record) => filament()->getUserAvatarUrl($record['assignedTo']))
                            ->label(fn (Task $record) => $record['assignedTo']['name'])
                            ->belowLabel('Responsável')
                            ->inlineLabel()
                            ->circular()
                            ->imageSize('3em')
                            ->alignRight()
                            ->columnSpanFull(),
                        TextEntry::make('predicted_hours')
                            ->label('Duração da tarefa')
                            ->numeric()
                            ->formatStateUsing(fn ($state) => $state . ' horas'),
                        TextEntry::make('due_date')
                            ->label('Prazo de conclusão')
                            ->date(),
                        TextEntry::make('description')
                            ->label('Descrição')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->contained(false)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('predicted_hours')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('conclusion_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('board.id')
                    ->searchable(),
                TextColumn::make('assigned_to')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalHeading('Nova Tarefa')
                    ->mutateDataUsing(function (array $data): array {
                        $data['board_id'] = 1;

                        return $data;
                    }),
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalHeading(fn (Task $record) => $record['title'])
                    ->modalWidth(Width::Medium)
                    ->modalFooterActions(fn (Task $record) =>
                        filament()->auth()->id() === $record['assigned_to'] ?
                            [Action::make('Concluir')] :
                            []
                    ),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
