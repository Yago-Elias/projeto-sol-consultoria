<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Project;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
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
                            
                            ])
                            ->columnSpanFull(),
                        
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
                            ->label('Data de Término'),
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
                        TextInput::make('estimated_price')
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                                'xl' => 4,
                            ])
                            ->numeric()
                            ->label('Previsão de Lucro')
                            ->prefix('R$')
                            ->placeholder('0,00')
                            ->disabled(fn ($operation) => $operation === 'edit'),
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
                        Select::make('payment')
                            ->columnSpan([
                                'sm' => 2,
                                'md' => 3,
                                'lg' => 4,
                                'xl' => 4,
                            ])
                            ->label('Pagamento')
                            ->options([
                                'a_vista' => 'Á vista',
                                'parcelado_1x' => '1x',
                                'parcelado_2x' => '2x',
                                'parcelado_3x' => '3x',
                                'parcelado_4x' => '4x',
                            ])
                            ->disabled(fn ($operation) => $operation === 'edit'),
                    ]),
                
                Section::make('Consultores')
                    ->columnSpanFull()
                    ->headerActions([
                        Action::make('add_consultant')
                            ->label('Adiconar Consultor')
                            ->icon(Heroicon::Plus)
                            ->schema([
                                Select::make('consultores')
                                    ->label('Buscar Consultor')
                                    ->placeholder('Busque pelo nome ou especialidade do consultor')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->options(function () {
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
                                $atual = $get('consultores_selecionados');
                                $novos = $data['consultores'] ?? [];

                                $total = array_unique(array_merge($atual, $novos));
                                $set('consultores_selecionados', $total);
                            })
                            ->modalSubmitActionLabel('Adicionar')
                            ->modalCancelActionLabel('Cancelar')
                        ])
                    ->schema([
                            Hidden::make('consultores_selecionados')
                                ->default([]),
                            ViewField::make('selected_consultants')
                                ->view('filament.resources.projects.partials.list-consultants-project')
                                ->viewData(function (?Project $record, $operation, Get $get) {
                                    if ($operation === 'edit') {
                                        return [
                                            'consultants' => $record
                                                ->collaborators()
                                                ->get()
                                                ->all()
                                        ];
                                    }
                                    $ids_consultants = $get('consultores_selecionados');
                                    $consultants = User::query()
                                        ->with('role:id,role')
                                        ->findMany($ids_consultants, ['name', 'image', 'role_id'])
                                        ->all();

                                    return ['consultants' => $consultants];
                                })
                                ->live(debounce:500)
                    ])
            ]);
    }
}
