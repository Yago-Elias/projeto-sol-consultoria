<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\FinancialNature;
use App\Models\FinancialType;
use App\Models\Provider;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ManageFinance extends ManageRelatedRecords
{
    protected static string $resource = ProjectResource::class;

    protected static string $relationship = 'financialEntries';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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
        $total = count($this->record['tasks']);
        $status = $this->record['tasks']->groupBy('status');
        $percentage = $total > 0 ? 100 * count($status['APROVADA']) / $total : 0;

        return [
            Action::make('progress-bar')
                ->view('filament.resources.projects.partials.circle-progress')
                ->viewData([
                    'percentage' => $percentage,
                    'endDate' => $this->record['end_date']
                ]),
        ];
    }

    public function form(Schema $schema): Schema
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
                    ->label('Data de pagamento'),
                Select::make('type')
                    ->label('Tipo de pagamento')
                    ->required()
                    ->searchable()
                    ->options(fn () => FinancialType::query()->pluck('type', 'id')),
                Select::make('nature')
                    ->label('Natureza')
                    ->required()
                    ->options(fn () => FinancialNature::query()->pluck('nature', 'id')),
                Select::make('provider')
                    ->label('Fornecedor')
                    ->searchable()
                    ->options(fn () => Provider::query()->pluck('provider', 'id'))
                    ->required(),
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
                Select::make('nature')
                    ->label('Natureza')
                    ->required()
                    ->options(fn () => FinancialNature::query()->pluck('nature', 'id')),
                Select::make('provider')
                    ->label('Fornecedor')
                    ->options(fn () => Provider::query()->pluck('provider', 'id'))
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
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
                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('BRL')
                    ->summarize([
                        Sum::make()
                            ->label('Total Receita')
                            ->money('BRL')
                            ->prefix('R$')
                    ])
                    ->sortable(),
                TextColumn::make('total_installments')
                    ->label('Parcelas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Vencimento')
                    ->date()
                    ->sortable(),
                TextColumn::make('payment_date')
                    ->label('Pagamento')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
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
                CreateAction::make()
                    ->label('Criar entrada financeira')
                    ->modalHeading('Criar entrada financeira'),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ]);
    }
}
