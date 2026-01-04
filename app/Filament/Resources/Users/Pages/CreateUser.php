<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Cadastrar Consultor';

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Cadastrar');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
//        TO-DO:
//        - gerar senha aleatória
//        - enviar senha por email
//
        $randomPassword = 'password';
        $data['password'] = Hash::make($randomPassword);

        return $data;
    }
}
