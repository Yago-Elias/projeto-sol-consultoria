<x-filament-panels::page>
    <livewire:criar-quadro :project="$record"/>

    <div class="flex gap-4 flex-nowrap overflow-x-auto p-1">
        @forelse(['PENDENTE', 'EM_PROGRESSO', 'EM_APROVACAO', 'APROVADA'] as $status)
            <div class="min-w-xs max-w-sm">
                @livewire(\App\Filament\Resources\Projects\RelationManagers\TasksRelationManager::class, [
                    'ownerRecord' => $record,
                    'pageClass' => static::class,
                    'status' => $status
                ])
            </div>
        @empty
            <x-filament::empty-state>
                <x-slot name="heading">
                    Projeto Vazio
                </x-slot>
                <x-slot name="description">
                    Crie um quadro para começar a criar tarefas
                </x-slot>
            </x-filament::empty-state>
        @endforelse
    </div>

    @php
        $tasks_status = $record['tasks']->groupBy('status');
        $late_tasks = [];

        if (isset($tasks_status['PENDENTE']))
            $late_tasks = $tasks_status['PENDENTE']
                ->filter(fn (\App\Models\Task $task) => $task['due_date'] < now());
    @endphp

    <div  class="grid lg:grid-cols-4 md:grid-cols-2 gap-4">
        <div class="text-center gap-2 rounded-lg border border-gray-800 p-2 bg-gray-100 items-center justify-center">
            <div class="text-2xl font-bold text-gray-900">
                {{ count($tasks_status['PENDENTE'] ?? []) }}
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
                {{ count($tasks_status['EM_APROVACAO'] ?? []) }}
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
                {{ count($late_tasks) }}
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
                {{ count($tasks_status['APROVADA'] ?? []) }}
            </div>
            <div class="flex flex-row gap-2 content-center w-fit mx-auto">
                <p class="text-success-800 text-sm">Tarefas Concluídas</p>
                <span class="text-success-900">
                    <x-filament::icon icon="heroicon-o-check-circle" />
                </span>
            </div>
        </div>
    </div>
</x-filament-panels::page>
