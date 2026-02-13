<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    public function searchConsultants(array $ids): array
    {
        return ProjectResource::searchConsultants($ids);
    }

    protected function handleRecordCreation(array $data): Model
    {
        $newProject = parent::handleRecordCreation($data);

        $newProject->collaborators()->attach($data['selected_consultants']);

        // TODO: adicionar preço no financeiro

        return $newProject;
    }
}
