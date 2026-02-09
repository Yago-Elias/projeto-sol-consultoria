<x-filament-panels::page>
    <div class="flex gap-4 flex-nowrap overflow-x-auto p-1">
        @php
            $boards = $record['boards']
                ->sortBy('updated_at')
                ->filter(fn ($board) => isset(($board['tasks']->groupBy('status'))['EM_APROVACAO']))
        @endphp
        @forelse($boards as $board)
            <div class="min-w-xs max-w-sm">
                @livewire(\App\Filament\Resources\Projects\RelationManagers\TasksRelationManager::class, [
                    'ownerRecord' => $record,
                    'pageClass' => static::class,
                    'board' => $board
                ])
            </div>
        @empty
            <x-filament::empty-state class="w-full">
                <x-slot name="heading">
                    Sem tarefas em aprovação
                </x-slot>
                <x-slot name="description">
                    Tarefas concluídas aparecerão aqui para serem aprovadas
                </x-slot>
            </x-filament::empty-state>
        @endforelse
    </div>
</x-filament-panels::page>
