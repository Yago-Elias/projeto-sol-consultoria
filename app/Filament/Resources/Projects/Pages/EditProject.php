<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    public function searchConsultants(array $ids): array
    {
        return ProjectResource::searchConsultants($ids);
    }

    public function removeConsultant(int $id): void
    {
        ProjectResource::removeConsultant($id, $this->record);
    }
}
