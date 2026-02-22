<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class MyProfile extends Page
{
    protected string $view = 'filament.pages.my-profile';
    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string|Htmlable
    {
        return filament()->auth()->user()['name'];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('logout')
                ->url(filament()->getLogoutUrl())
                ->postToUrl()
                ->label('Sair')
                ->icon('heroicon-o-arrow-left-start-on-rectangle')
                ->extraAttributes([
                    'class' => 'bg-(--claro-3)'
                ])
        ];
    }
}
