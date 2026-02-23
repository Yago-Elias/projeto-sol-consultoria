<x-filament-panels::page>
    <livewire:criar-quadro :project="$record"/>

    <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-4 flex-nowrap overflow-x-auto p-1">
        @foreach(['PENDENTE', 'EM_PROGRESSO', 'EM_APROVACAO', 'APROVADA'] as $status)
            @php
                $title = match($status) {
                    'PENDENTE' => 'Pendentes',
                    'EM_PROGRESSO' => 'Em Progresso',
                    'EM_APROVACAO' => 'Esperando Aprovação',
                    'APROVADA' => 'Aprovadas'
                };
                $icon = match($status) {
                    'EM_PROGRESSO' => 'heroicon-o-clipboard-document-list',
                    'EM_APROVACAO' => 'heroicon-o-clock',
                    default => 'heroicon-o-check-circle'
                };
                $color = match($status) {
                    'PENDENTE' => 'gray',
                    'EM_PROGRESSO' => 'info',
                    'EM_APROVACAO' => 'warning',
                    'APROVADA' => 'success'
                };
            @endphp
            <x-filament::section :icon="$icon" :icon-color="$color" class="h-fit">
                <x-slot name="heading">
                    {{ $title }}
                </x-slot>
                @livewire(\App\Filament\Resources\Projects\RelationManagers\TasksRelationManager::class, [
                    'ownerRecord' => $record,
                    'pageClass' => static::class,
                    'status' => $status
                ])
            </x-filament::section>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-4">
        <div class="text-center gap-2 rounded-lg border border-gray-800 p-2 bg-gray-100 items-center justify-center">
            <div class="text-2xl font-bold text-gray-900">
                {{ $record->pendingTasks }}
            </div>
            <div class="flex flex-row gap-2 content-center w-fit mx-auto">
                <p class="text-gray-800 text-sm">Tarefas Pendentes</p>
                <span class="text-gray-400">
                    <x-filament::icon icon="heroicon-o-check-circle" />
                </span>
            </div>
        </div>
        <div class="text-center gap-2 rounded-lg border border-warning-800 p-2 bg-warning-100 items-center justify-center">
            <div class="text-2xl font-bold text-primary-900">
                {{ $record->getTasksByStatus('EM_APROVACAO') }}
            </div>
            <div class="flex flex-row gap-2 content-center w-fit mx-auto">
                <p class="text-primary-800 text-sm">Tarefas em Aprovação</p>
                <span class="text-primary-900">
                    <x-filament::icon icon="heroicon-o-clock" />
                </span>
            </div>
        </div>
        <div class="text-center gap-2 rounded-lg border border-danger-800 p-2 bg-danger-100 items-center justify-center">
            <div class="text-2xl font-bold text-danger-900">
                {{ $record->overdueTasks }}
            </div>
            <div class="flex flex-row gap-2 content-center w-fit mx-auto">
                <p class="text-danger-800 text-sm">Tarefas Atrasadas</p>
                <span class="text-danger-900">
                    <x-filament::icon icon="heroicon-o-exclamation-circle" />
                </span>
            </div>
        </div>
        <div class="text-center gap-2 rounded-lg border border-success-800 p-2 bg-success-100 items-center justify-center">
            <div class="text-2xl font-bold text-success-900">
                {{ $record->getTasksByStatus('APROVADA') }}
            </div>
            <div class="flex flex-row gap-2 content-center w-fit mx-auto">
                <p class="text-success-800 text-sm">Tarefas Concluídas</p>
                <span class="text-success-900">
                    <x-filament::icon icon="heroicon-o-check-circle" />
                </span>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            document.querySelectorAll('.kanban-column').forEach(column => {
                Sortable.create(column, {
                    group: 'tasks',
                    handle: '.handle',
                    animation: 150,
                    onEnd: function(evt) {
                        if (evt.from === evt.to) return;

                        let itemId = evt.item.dataset.id;
                        let toWireId = evt.to.closest('[wire\\:id]').getAttribute('wire:id');

                        Livewire.find(toWireId).call('receiveTask', itemId);
                    }
                });
            });
        });
    </script>
</x-filament-panels::page>
