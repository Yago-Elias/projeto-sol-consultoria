<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard;
use Illuminate\Contracts\Support\Htmlable;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Filament\Facades\Filament;

class DashboardSol extends Dashboard
{
    # protected string $view = 'filament.pages.dashboard';

    public function getTitle() : string | Htmlable {
        return "Dashboard";
    }

    public static function getNavigationIcon() : string | BackedEnum | Htmlable | null {
        return Heroicon::Home;
    }
}
