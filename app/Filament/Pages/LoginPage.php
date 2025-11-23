<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\Login;
use Filament\Schemas\Schema;

class LoginPage extends Login
{
    protected string $view = 'filament.pages.login';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }
}

