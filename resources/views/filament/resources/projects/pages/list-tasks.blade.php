<x-project-layout activeTab="{{ $activeTab }}" :urls="$urls">
    <div>
        @livewire('criar-quadro', ['projectId' => $record['id']])
    </div>
    @livewire(\App\Filament\Resources\Projects\RelationManagers\BoardsRelationManager::class, [
        'ownerRecord' => $record,
        'pageClass' => static::class,
    ])
</x-project-layout>
