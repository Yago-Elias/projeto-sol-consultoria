<x-project-layout activeTab="{{ $activeTab }}" :urls="$urls">
    @livewire(\App\Filament\Resources\Projects\RelationManagers\TasksRelationManager::class, [
        'ownerRecord' => $record,
        'pageClass' => static::class
    ])
</x-project-layout>
