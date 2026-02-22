<?php

namespace App\Livewire;

use App\Models\FinancialType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class PaymentTypesTable extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => FinancialType::query())
            ->columns([
                TextColumn::make('type')
                    ->label('Tipos de pagamento'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Criar Novo')
                    ->schema([
                        TextInput::make('type')
                            ->label('Tipo de Pagamento')
                    ])
            ])
            ->recordActions([
                EditAction::make()
                    ->schema([
                        TextInput::make('type')
                            ->label('Tipo de Pagamento')
                    ]),
                DeleteAction::make()
            ]);
    }

    public function render(): View
    {
        return view('livewire.payment-types-table');
    }
}
