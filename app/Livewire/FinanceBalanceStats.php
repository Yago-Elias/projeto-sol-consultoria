<?php

namespace App\Livewire;

use App\Models\Project;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinanceBalanceStats extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    public ?Project $record = null;

    protected function getStats(): array
    {
        $entries = $this->record->financialEntries()
            ->with('financialNature')
            ->whereNotNull('payment_date')
            ->get();

        $receita = $entries
            ->where('financialNature.nature', 'Payment')
            ->sum('total_amount');

        $custos = $entries
            ->where('financialNature.nature', 'Expense')
            ->sum('total_amount');

        $lucro = $receita - $custos;

        return [
            Stat::make('Receita', 'R$ ' . number_format($receita, 2, ',', '.'))
                ->description('Total de receitas pagas')
                ->color('success')
                ->icon(Heroicon::OutlinedArrowTrendingUp),

            Stat::make('Custos', 'R$ ' . number_format($custos, 2, ',', '.'))
                ->description('Total de despesas pagas')
                ->color('danger')
                ->icon(Heroicon::OutlinedArrowTrendingDown),

            Stat::make('Lucro', 'R$ ' . number_format($lucro, 2, ',', '.'))
                ->description('Receita menos custos')
                ->color($lucro >= 0 ? 'success' : 'danger')
                ->icon(Heroicon::OutlinedBanknotes),
        ];
    }
}
