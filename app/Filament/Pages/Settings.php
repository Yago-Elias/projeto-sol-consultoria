<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class Settings extends Page
{
    protected string $view = 'filament.pages.settings';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $title = 'Configurações';

    public static function canAccess(): bool
    {
        return auth()->user()->can('settings', User::class);
    }
}
