<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Livewire\FinanceBalanceStats;
use App\Permissions;
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
        $profile = $user['profile'];

        $canEdit = $profile['global_access'] || ($profile['project_manager'] & Permissions::EDIT);

        return [
            EditAction::make()
                ->icon(Heroicon::OutlinedPencilSquare)
                ->visible($canEdit),
        ];
    }
}
