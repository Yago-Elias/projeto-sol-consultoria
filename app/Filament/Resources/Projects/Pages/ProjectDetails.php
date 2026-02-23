<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Livewire\FinanceBalanceStats;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;

class ProjectDetails extends ViewProject
{
    protected static ?string $navigationLabel = 'Detalhes';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::ListBullet;
    protected string $view = 'filament.resources.projects.pages.project-details';

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

    public function getHeaderActions(): array
    {
        $user = filament()->auth()->user();

        return [
            EditAction::make()
                ->icon(Heroicon::OutlinedPencilSquare)
                ->visible($user->can('update', $this->record)),
        ];
    }
}
