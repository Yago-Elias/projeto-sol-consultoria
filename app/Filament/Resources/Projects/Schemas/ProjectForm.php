<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Filament\Forms\Components\Consultants;
use App\Models\FinancialType;
use App\Models\Project;
use App\Models\User;
use App\Permissions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Support\Icons\Heroicon;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProjectForm extends Component
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informações do Projeto')
                    ->columns([
                        'sm' => 4,
                        'md' => 6,
                        'lg' => 8,
                        'xl' => 12,
                    ])
                    ->columnSpanFull()
                    ->schema([
                        View::make('filament.schemas.components.layout-create-project')
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('name')
                                    ->columnSpan([
                                        'md' => 3,
                                        'lg' => 5,
                                        'xl' => 8,
                                    ])
                                    ->required()
                                    ->label('Nome do Projeto')
                                    ->placeholder('Nome'),
                                FileUpload::make('image')
                                    ->columnSpan([
                                        'md' => 3,
                                        'lg' => 3,
                                        'xl' => 4,
                                    ])
                                    ->label('Clique para adicionar uma imagem')
                                    ->image()
                                    ->imageEditor()
                                    ->alignCenter(),
                                TextInput::make('company_name')
                                    ->columnSpan([
                                        'md' => 3,
                                        'lg' => 5,
                                        'xl' => 8,
                                    ])
                                        ->required()
                                        ->label('Empresa Cliente')
                                        ->placeholder('Empresa'),
                                TextInput::make('company_email')
                                    ->columnSpan([
                                        'md' => 3,
                                        'lg' => 5,
                                        'xl' => 8,
                                    ])
                                    ->email()
                                    ->required()
                                    ->label('E-mail')
                                    ->placeholder('E-mail'),
                            ]),

                        Textarea::make('description')
                            ->columnSpanFull()
                            ->label('Descrição do Projeto')
                            ->placeholder('Descrição'),
                        DatePicker::make('start_date')
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                                'xl' => 4,
                            ])
                            ->required()
                            ->label('Data de Início')
                            ->disabled(fn ($operation) => $operation === 'edit'),

                        DatePicker::make('end_date')
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                                'xl' => 4,
                            ])
                            ->required()
                            ->minDate(now())
                            ->label('Data de Término'),
                        TextInput::make('project_price')
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                                'xl' => 4,
                            ])
                            ->required()
                            ->numeric()
                            ->label('Preço do Projeto')
                            ->prefix('R$')
                            ->placeholder('0,00')
                            ->disabled(fn ($operation) => $operation === 'edit'),
                        TextInput::make('estimated_cost')
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                                'xl' => 4,
                            ])
                            ->numeric()
                            ->label('Previsão de Custos')
                            ->prefix('R$')
                            ->placeholder('0,00')
                            ->disabled(fn ($operation) => $operation === 'edit'),
                        Select::make('payment')
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                                'xl' => 4,
                            ])
                            ->label('Pagamento')
                            ->options([
                                '1' => 'Á vista',
                                '2' => '2x',
                                '3' => '3x',
                                '4' => '4x',
                            ])
                            ->disabled(fn ($operation) => $operation === 'edit'),
                        Select::make('payment_type')
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                                'xl' => 4,
                            ])
                            ->label('Tipo de Pagamento')
                            ->options(fn () => FinancialType::query()->pluck('type', 'id'))
                            ->disabled(fn ($operation) => $operation === 'edit'),

                    ]),

                Section::make('Consultores')
                    ->columnSpanFull()
                    ->headerActions([
                        Action::make('add_consultant')
                            ->label('Adicionar Consultor')
                            ->icon(Heroicon::Plus)
                            ->schema([
                                Select::make('select_consultant')
                                    ->label('Buscar Consultor')
                                    ->placeholder('Busque pelo nome ou especialidade do consultor')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->options(function (?Project $record, Get $get) {
                                        if ($record) {
                                            $projectId = $record->id;
                                            return User::query()
                                                ->whereDoesntHave('projects', function ($q) use ($projectId) {
                                                    $q->where('projects.id', $projectId);
                                                })
                                                ->get()
                                                ->pluck('name', 'id');
                                        }

                                        return User::query()->pluck('name', 'id');
                                    })
                                    ->getSearchResultsUsing(function (string $search) {
                                        return User::query()
                                            ->where('name', 'like', "%{$search}%")
                                            ->limit(10)
                                            ->pluck('name', 'id');
                                    })
                            ])
                            ->action(function (array $data, Set $set, Get $get) {
                                $current = $get('selected_consultants');
                                $new = $data['select_consultant'] ?? [];

                                $merge = array_unique(array_merge($current ?? [], $new));
                                $set('selected_consultants', $merge);
                            })
                            ->modalSubmitActionLabel('Adicionar')
                            ->modalCancelActionLabel('Cancelar')
                            ->closeModalByClickingAway(false)
                        ])
                    ->schema([
                        Hidden::make('selected_consultants')
                            ->default([]),
                        Hidden::make('remove_consultants')
                            ->default([]),
                        ViewField::make('consultants')
                            ->view('filament.resources.projects.partials.list-consultants-project')
                            ->viewData(function (?Project $record, $operation, Set $set, Get $get) {
                                $ids_consultants = $get('selected_consultants') ?? [];

                                if ($operation === 'edit') {
                                    $savedIds = $record
                                        ->collaborators()
                                        ->whereNotIn('id', $get('remove_consultants') ?? [])
                                        ->pluck('id')
                                        ->toArray();

                                    $ids_consultants = array_merge($ids_consultants, $savedIds);
                                }

                                $ids_consultants[] = $get('manager_id');

                                $consultants = User::query()
                                    ->with('role:id,role')
                                    ->findMany($ids_consultants, ['id', 'name', 'image', 'role_id'])
                                    ->map(fn ($user) => [
                                        'id' => $user->id,
                                        'name' => $user->name,
                                        'image' => filament()->getUserAvatarUrl($user),
                                        'role' => $user->role->role,
                                    ])
                                    ->all();

                                return ['consultants' => $consultants];
                            })
                            ->live(debounce:500)
                            ->after(function (?Project $project, Get $get, Set $set, $operation) {
                                $consultantsIds = $get('selected_consultants') ?? [];
                                $removeConsultantsIds = $get('remove_consultants') ?? [];
                                if ($consultantsIds) {
                                    $project?->collaborators()->attach($consultantsIds);
                                }
                                if ($removeConsultantsIds) {
                                    $project?->collaborators()->detach($removeConsultantsIds);
                                }
                            }),
                        Select::make('manager_id')
                            ->columnSpanFull()
                            ->label('Gerente do projeto')
                            ->required()
                            ->preload()
                            ->relationship('manager', 'name')
                            ->options(function (?Project $project, Get $get, $operation) {
                                $consultants = $get('selected_consultants') ?? [];

                                if ($operation === 'edit')
                                    $consultants = array_merge($consultants, $project->collaborators()->pluck('id')->toArray());

                                return User::query()
                                    ->findMany($consultants)
                                    ->whereNotIn('id', $get('remove_consultants') ?? [])
                                    ->filter(fn (User $user) => $user['profile']['manage_projects'] & Permissions::MANAGE_PROJECTS)
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                    ])
            ]);
    }
}
