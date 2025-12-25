<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Cadastrar Consultor';

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Cadastrar');
    }
}
