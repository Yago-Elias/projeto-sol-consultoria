<x-project-layout activeTab="{{ $activeTab }}" :urls="$urls">
    <div class="grid grid-cols-3 gap-4">
        @foreach($project['boards'] as $board)
            @livewire(\App\Filament\Resources\Projects\RelationManagers\TasksRelationManager::class, [
                'ownerRecord' => $record,
                'pageClass' => static::class,
                'board' => $board
            ])
        @endforeach
    </div>
</x-project-layout>
