<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Mail\NewUserPassword;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static ?string $title = 'Cadastrar Consultor';

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Cadastrar');
    }

    protected function handleRecordCreation(array $data): Model
    {
        srand(now()->getTimestamp());

        $data['password'] = Hash::make(Str::random());
        $newUser = static::getModel()::create($data);

        Mail::to($newUser)
            ->send(new NewUserPassword($newUser));

        return $newUser;
    }
}
