<?php

namespace App\Livewire;

use App\Models\Installment;
use App\Models\Project;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\On;

class FinanceBalanceStats extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    public ?Project $record = null;

    protected function getStats(): array
    {
        $installments = Installment::query()
            ->whereHas('financialEntry', fn ($q) => $q->where('project_id', $this->record->id))
            ->with('financialEntry.financialNature')
            ->get();
        
        // receita já paga
        $paid_revenue = $installments
            ->filter(fn ($i) => $i->payment_date !== null
                && $i->financialEntry->financialNature?->nature === 'Receita')
                ->sum('value');
        
        // receita a ser paga
        $uncollected_revenue = $installments
            ->filter(fn ($i) => $i->payment_date == null
                && $i->financialEntry->financialNature?->nature === 'Receita')
            ->sum('value');

        // custo pago
        $cost_paid = $installments
            ->filter(fn ($i) => $i->payment_date !== null
                && $i->financialEntry->financialNature?->nature === 'Custo')
            ->sum('value');

        // custo à pagar
        $accounts_payable = $installments
            ->filter(fn ($i) => $i->payment_date === null
                && $i->financialEntry->financialNature?->nature === 'Custo')
            ->sum('value');

        $profit    = $paid_revenue - $cost_paid;

        return [
            Stat::make('Receita Recebida', 'R$ ' . number_format($paid_revenue, 2, ',', '.'))
                ->description('Pendente: R$ ' . number_format($uncollected_revenue, 2, ',', '.'))
                ->color('success')
                ->icon(Heroicon::OutlinedArrowTrendingUp),

            Stat::make('Custos Pagos', 'R$ ' . number_format($cost_paid, 2, ',', '.'))
                ->description('Pendente: R$ ' . number_format($accounts_payable, 2, ',', '.'))
                ->color('danger')
                ->icon(Heroicon::OutlinedArrowTrendingDown),

            Stat::make('Lucro Realizado', 'R$ ' . number_format($profit, 2, ',', '.'))
                ->description('Baseado nas parcelas pagas')
                ->color($profit >= 0 ? 'success' : 'danger')
                ->icon(Heroicon::OutlinedBanknotes),
        ];
    }

    #[On('update_balance')]
    public function updateBalance(): void
    {
        $this->dispatch('$refresh');
    }
}
