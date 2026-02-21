<?php

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\ProfileResource;
use App\Permissions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageProfiles extends ManageRecords
{
    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->mutateDataUsing(function (array $data) {
                    if ($data['global_access']) {
                        $data['manage_projects'] = ['c', 'e', 'd', 'f', 'm', 'l'];
                        $data['task_access'] = ['c', 'e', 'd', 'a'];
                        $data['manage_users'] = ['c', 'e', 'd', 'l'];
                    }

                    $data['manage_projects'] = ProfileResource::arrayToNum($data['manage_projects']);
                    $data['task_access'] = ProfileResource::arrayToNum($data['task_access']);
                    $data['manage_users'] = ProfileResource::arrayToNum($data['manage_users']);
                    $data['financial_access'] = 0;

                    return $data;
                }),
        ];
    }
}
