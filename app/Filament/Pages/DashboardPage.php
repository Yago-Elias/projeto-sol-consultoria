<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Dashboard;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class DashboardPage extends Dashboard
{
    public function getTitle(): string|Htmlable
    {
        return "Dashboard";
    }

    public function getSubheading(): string|Htmlable|null
    {
        $user = filament()->auth()->user();
        $name = filament()->getUserName($user);

        return "Bem vindo(a) de volta, {$name}!";
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return Heroicon::OutlinedHome;
    }

    public static function getNavigationLabel(): string
    {
        return "Dashboard";
    }

    public function getColumns(): int | array
    {
        return 1;
    }
}
