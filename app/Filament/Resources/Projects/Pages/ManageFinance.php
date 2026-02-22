<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Livewire\FinanceBalanceStats;
use App\Livewire\TableInstallment;
use App\Models\FinancialEntry;
use App\Models\FinancialNature;
use App\Models\FinancialType;
use App\Models\Installment;
use App\Models\Provider;
use App\Permissions;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ManageFinance extends ManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;

    protected static string $relationship = 'financialEntries';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'Financeiro';

    public function getTitle(): string|Htmlable
    {
        return $this->record['name'];
    }

    public function getBreadcrumb(): string
    {
        return 'Visualizar';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('progress-bar')
                ->view('filament.resources.projects.partials.circle-progress')
                ->viewData([
                    'percentage' => $this->record->progress,
                    'endDate' => $this->record['end_date']
                ]),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('type_nature'),
                Hidden::make('nature'),
                Textarea::make('description')
                    ->label('Descrição')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('total_amount')
                    ->label('Valor')
                    ->prefix('R$')
                    ->required()
                    ->numeric()
                    ->disabled(fn ($operation) => $operation === 'edit'),
                TextInput::make('total_installments')
                    ->label('Nº de parcelas')
                    ->required()
                    ->numeric()
                    ->disabled(fn ($operation) => $operation === 'edit'),
                DatePicker::make('due_date')
                    ->label('Data de vencimento')
                    ->required(),
                DatePicker::make('payment_date')
                    ->label('Data de pagamento'),
                Select::make('type')
                    ->label('Tipo de pagamento')
                    ->required()
                    ->searchable()
                    ->options(fn () => FinancialType::query()->pluck('type', 'id')),
                Select::make('provider')
                    ->label('Fornecedor')
                    ->searchable()
                    ->options(fn () => Provider::query()->pluck('provider', 'id'))
                    ->required()
                    ->visible(fn ($get) => $get('type_nature') === 'cost'),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('description')
                    ->label('Descrição')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('total_amount')
                    ->label('Valor')
                    ->prefix('R$')
                    ->required()
                    ->numeric(),
                TextInput::make('total_installments')
                    ->label('Nº de parcelas')
                    ->required()
                    ->numeric(),
                DatePicker::make('due_date')
                    ->label('Data de vencimento')
                    ->required(),
                DatePicker::make('payment_date')
                    ->label('Data de pagamento')
                    ->required(),
                Select::make('type')
                    ->label('Tipo de pagamento')
                    ->required()
                    ->options(fn () => FinancialType::query()->pluck('type', 'id')),
                Select::make('provider')
                    ->label('Fornecedor')
                    ->options(fn () => Provider::query()->pluck('provider', 'id'))
                    ->required()
                    ->visible(fn (FinancialEntry $record) => $record->provider),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->withSum(['installments as installments_total'], 'value'))
            ->recordTitleAttribute('description')
            ->groups([
                Group::make('financialNature.nature')
                    ->label('Natureza')
                    ->collapsible(),
                Group::make('financialType.type')
                    ->label('Tipo de pagamento')
                    ->collapsible(),
            ])
            ->columns([
                TextColumn::make('installments_total')
                    ->label('Total')
                    ->money('BRL')
                    ->sortable(),
                TextColumn::make('installments_count')
                    ->label('Parcelas')
                    ->counts('installments')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Vencimento')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('payment_date')
                    ->label('Pagamento')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->date('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->date('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('financialType.type')
                    ->label('Tipo')
                    ->sortable(),
                TextColumn::make('financialNature.nature')
                    ->label('Natureza')
                    ->sortable(),
                TextColumn::make('providerModel.provider')
                    ->label('Fornecedor')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('financialType')
                    ->label('Tipo de pagamento')
                    ->relationship('financialType', 'type'),
                SelectFilter::make('providerModel')
                    ->label('Fornecedores')
                    ->relationship('providerModel', 'provider'),
            ])
            ->headerActions([
                CreateAction::make('revenue')
                    ->label('Criar Nova Receita')
                    ->fillForm([
                        'type_nature' => 'revenue',
                        'nature' => 2
                        ])
                    ->modalHeading('Nova Receita')
                    ->after(fn (FinancialEntry $record) => $record->create_installments()),
                CreateAction::make('cost')
                    ->label('Criar Novo Custo')
                    ->fillForm([
                        'type_nature' => 'cost',
                        'nature' => 1
                        ])
                    ->modalHeading('Novo Custo')
                    ->after(fn (FinancialEntry $record) => $record->create_installments()),
            ])
            ->recordActions([
                Action::make('installments')
                    ->label('Parcelas')
                    ->icon(Heroicon::OutlinedListBullet)
                    ->modalHeading(fn (FinancialEntry $record) => "Parcelas — {$record->description}")
                    ->modalContent(fn (FinancialEntry $record) => view(
                        'filament.resources.projects.partials.installments-modal',
                        ['financial_entry' => $record]
                    ))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Fechar'),
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make()
                        ->before(function (FinancialEntry $record, EditAction $action) {
                            $hasPaidInstallments = $record->installments()
                                ->where('payment_date', '<>', 'null')
                                ->exists();
                            
                            if ($hasPaidInstallments) {
                                Notification::make()
                                    ->title('Alteração bloqueada')
                                    ->body('Esta entrada possui parcelas já pagas e não pode ser editada.')
                                    ->danger()
                                    ->send();
                                $action->halt();
                            }
                        }),
                    DeleteAction::make(),
                ])
            ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FinanceBalanceStats::class,
        ];
    }

    public function getHeaderWidgetsData(): array
    {
        return [
            FinanceBalanceStats::class => [
                'record' => $this->record,
            ],
        ];
    }
    
    public static function canAccess(array $parameters = []): bool
    {
        return auth()->user()->can('finance', $parameters['record']);
    }
}
