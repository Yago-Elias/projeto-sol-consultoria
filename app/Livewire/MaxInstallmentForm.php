<?php

namespace App\Livewire;

use App\Models\Configuration;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Enums\IconSize;
use Livewire\Component;

class MaxInstallmentForm extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public Configuration $config;

    public function render()
    {
        return view('livewire.max-installment-form');
    }

    public function editAction(): Action
    {
        return EditAction::make()
            ->record($this->config)
            ->model(Configuration::class)
            ->modalWidth('md')
            ->schema([
                TextInput::make('max_installments')
                    ->label('Máximo de parcelas')
                    ->numeric()
            ])
            ->icon('heroicon-o-pencil-square')
            ->iconSize(IconSize::Large)
            ->iconButton()
            ->extraAttributes([
                'class' => 'text-(--escuro-1)'
            ])
            ->after(function () {
                $this->dispatch('refresh-install');
            });
    }
}
