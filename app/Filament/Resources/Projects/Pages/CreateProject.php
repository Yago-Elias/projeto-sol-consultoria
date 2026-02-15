<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\FinancialEntry;
use App\Models\FinancialNature;
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

        $projectPayment = new FinancialEntry([
            'description' => 'Pagamento do Projeto',
            'total_amount' => $newProject['project_price'],
            'total_installments' => $data['payment'],
            'due_date' => $newProject['start_date']->addMonth(),
            'project_id' => $newProject['id'],
            'type' => $data['payment_type'],
            'nature' => FinancialNature::query()->where('nature', 'Payment')->pluck('id')->first
        ]);
        $projectPayment->save();

        return $newProject;
    }
}
