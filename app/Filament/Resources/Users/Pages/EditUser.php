<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->disabled(fn (User $record): bool =>
                    count($record['managedProjects']) + count($record['projects']) > 0)
                ->before(function (User $record): void {
                    $record->expertises()->detach();
                })
                ->hidden(fn (User $record) => auth()->user()->cannot('delete', $record)),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['image'] ??= $this->getRecord()['image'];

        return $data;
    }
}
