<x-project-layout activeTab="{{ $activeTab }}" :urls="$urls">
    <div class="flex justify-between">
        @livewire('criar-quadro', ['projectId' => $record['id']])
    </div>
    <div class="flex gap-4 flex-nowrap overflow-x-auto p-1">
        @foreach($record['boards']->sortBy('name') as $board)
            <div class="min-w-sm max-w-sm">
                @livewire(\App\Filament\Resources\Projects\RelationManagers\TasksRelationManager::class, [
                    'ownerRecord' => $record,
                    'pageClass' => static::class,
                    'board' => $board
                ])
            </div>
        @endforeach
    </div>
</x-project-layout>
