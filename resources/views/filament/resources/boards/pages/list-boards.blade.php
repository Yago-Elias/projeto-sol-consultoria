<div>
    <div class="flex justify-between mb-4">
    </div>
    <div class="grid grid-cols-3 gap-4">
        @foreach($this->ownerRecord['boards'] as $board)
            @livewire(\App\Filament\Resources\Projects\RelationManagers\TasksRelationManager::class, [
                'ownerRecord' => $this->ownerRecord,
                'pageClass' => static::class,
                'board' => $board
            ])
        @endforeach
    </div>
</div>
