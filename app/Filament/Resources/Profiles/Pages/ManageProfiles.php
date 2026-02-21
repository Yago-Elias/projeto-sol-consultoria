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
                    $checkT = $data['task_access'];
                    $checkP = $data['manage_projects'];
                    $checkU = $data['manage_users'];

                    $data['manage_projects'] = in_array('c', $checkP) * Permissions::CREATE           |
                                               in_array('e', $checkP) * Permissions::EDIT             |
                                               in_array('d', $checkP) * Permissions::REMOVE           |
                                               in_array('m', $checkP) * Permissions::MANAGE_PROJECTS  |
                                               in_array('f', $checkP) * Permissions::FINANCIAL_ACCESS |
                                               in_array('l', $checkP) * Permissions::LIST_ALL_PROJECTS;

                    $data['task_access'] = in_array('c', $checkT) * Permissions::CREATE |
                                           in_array('e', $checkT) * Permissions::EDIT   |
                                           in_array('d', $checkT) * Permissions::REMOVE |
                                           in_array('a', $checkT) * Permissions::APPROVE_TASKS;

                    $data['manage_users'] = in_array('c', $checkU) * Permissions::CREATE |
                                            in_array('e', $checkU) * Permissions::EDIT   |
                                            in_array('d', $checkU) * Permissions::REMOVE |
                                            in_array('l', $checkU) * Permissions::LIST;

                    return $data;
                }),
        ];
    }
}
