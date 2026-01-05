<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Voltar')
                ->url($this->getResourceUrl('index'))
                ->color('neutro-1'),
            EditAction::make()
                ->icon(Heroicon::OutlinedPencilSquare)
                ->iconSize('md'),
        ];
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                View::make('filament.resources.users.pages.view-user')
                    ->viewData([
                        'user' => $this->record
                    ]),
            ]);
    }

    public function getTitle(): string|Htmlable
    {
        return $this->record['name'];
    }
}
