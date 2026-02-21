<?php

namespace App\Livewire;

use App\Models\FinancialEntry;
use App\Models\Installment;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class TableInstallment extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public FinancialEntry $financial_entry;

    public function table(Table $table): Table
    {
        return $table
            ->records(fn () => $this->financial_entry->installments()->get())
            ->columns([
                TextColumn::make('number')
                    ->label('Nº da parcela')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Valor da parcela')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Data de vencimento')
                    ->date()
                    ->sortable(),
                TextColumn::make('payment_date')
                    ->label('Data de pagamento')
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
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                Action::make('pay')
                    ->label(fn (Installment $record) => $record->payment_date ? 'Pago' : 'Pagar')
                    ->button()
                    ->color(fn (Installment $record) => $record->payment_date ? 'success' : 'warning')
                    ->disabled(fn (Installment $record) => $record->payment_date)
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar pagamento')
                    ->modalDescription(
                        fn (Installment $record) =>
                        "Deseja confirmar o pagamento da parcela Nº {$record->number} no valor de R$ {$record->value}?"
                    )
                    ->modalSubmitActionLabel('Sim, confirmar pagamento')
                    ->modalCancelActionLabel('Cancelar')
                    ->action(function (Installment $record) {
                        $record->markAsPaid();
                    })
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
                BulkAction::make('pay_select')
                    ->label('Confirmar pagamento das parcelas')
                    ->button()
                    ->icon('heroicon-o-check')
                    ->action(fn (Collection $records) => $records->each->markAsPaid())
                    ->requiresConfirmation(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.table-installment');
    }
}
