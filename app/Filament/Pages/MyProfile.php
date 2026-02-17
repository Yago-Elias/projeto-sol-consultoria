<?php

namespace App\Filament\Pages;

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
}
