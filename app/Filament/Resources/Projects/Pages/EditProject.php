<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Finalizar projeto')
                ->hidden(fn (Project $record) => auth()->user()->cannot('delete', $record)),
        ];
    }

    public function searchConsultants(array $ids): array
    {
        return ProjectResource::searchConsultants($ids);
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getFormContentComponent(),
            ]);
    }

    public function getSubNavigation(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $pagamento = $this->record['financialEntries']->where('financialNature.nature', 'Payment')->first();
        $data['payment'] = $pagamento['total_installments'];
        $data['payment_type'] = $pagamento['type'];
        return $data;
    }
}
