<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\Role;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('search')
                ->view('filament.resources.users.partials.search-bar'),
            CreateAction::make()
                ->label('Cadastrar')
                ->color('escuro-3')
                ->icon(Heroicon::OutlinedUserPlus)
                ->hidden(fn () => auth()->user()->cannot('create', User::class)),
        ];
    }

    public function getTabs(): array
    {
        $roles = Role::query()->get(['id', 'role'])->all();
        $tabs = ['all' => Tab::make('Todos')];

        foreach ($roles as $role)
            $tabs[$role['role']] = Tab::make($role['role'])
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role_id', $role['id']));

        return $tabs;
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getTabsContentComponent(),
                View::make('filament.resources.users.pages.list-users')
            ]);
    }
}
