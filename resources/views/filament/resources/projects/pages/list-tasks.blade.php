<x-project-layout activeTab="{{ $activeTab }}" :urls="$urls">
    <div class="flex justify-between">
        @livewire('criar-quadro', ['projectId' => $record['id']])
    </div>

    <div class="flex gap-4 flex-nowrap overflow-x-auto p-1">
        @foreach($record['boards']->sortBy('name') as $board)
            <div class="min-w-xs max-w-sm">
                @livewire(\App\Filament\Resources\Projects\RelationManagers\TasksRelationManager::class, [
                    'ownerRecord' => $record,
                    'pageClass' => static::class,
                    'board' => $board
                ])
            </div>
        @endforeach
    </div>

    @php
        $tasks_status = $record['tasks']->groupBy('status');
        $late_tasks = $tasks_status['PENDENTE']->filter(fn (\App\Models\Task $task) => $task['due_date'] < now());
    @endphp

    <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-4">
        <div class="flex flex-row gap-2 rounded-lg border border-gray-800 p-2 bg-gray-100 items-center justify-center">
            <div class="content-center text-center">
                <div class="text-2xl font-bold text-gray-900">
                    {{ count($tasks_status['PENDENTE']) }}
                </div>
                <div class="text-gray-800 text-sm">Tarefas Pendentes</div>
            </div>
            <div class="text-gray-400">
                <x-filament::icon icon="heroicon-o-check-circle" />
            </div>
        </div>
        <div class="flex flex-row gap-2 rounded-lg border border-warning-800 p-2 bg-warning-100 items-center justify-center">
            <div class="content-center text-center">
                <div class="text-2xl font-bold text-primary-900">
                    {{ count($tasks_status['EM_APROVACAO']) }}
                </div>
                <div class="text-primary-800 text-sm">Tarefas em Aprovação</div>
            </div>
            <div class="text-primary-900">
                <x-filament::icon icon="heroicon-o-clock" />
            </div>
        </div>
        <div class="flex flex-row gap-2 rounded-lg border border-danger-800 p-2 bg-danger-100 items-center justify-center">
            <div class="content-center text-center">
                <div class="text-2xl font-bold text-danger-900">
                    {{ count($late_tasks) + count($tasks_status['ATRASADA']) }}
                </div>
                <div class="text-danger-800 text-sm">Tarefas Atrasadas</div>
            </div>
            <div class="text-danger-900">
                <x-filament::icon icon="heroicon-o-exclamation-circle" />
            </div>
        </div>
        <div class="flex flex-row gap-2 rounded-lg border border-success-800 p-2 bg-success-100 items-center justify-center">
            <div class="content-center text-center">
                <div class="text-2xl font-bold text-success-900">
                    {{ count($tasks_status['APROVADA']) + count($tasks_status['FINALIZADA_COM_ATRASO']) }}
                </div>
                <div class="text-success-800 text-sm">Tarefas Concluídas</div>
            </div>
            <div class="text-success-900">
                <x-filament::icon icon="heroicon-o-check-circle" />
            </div>
        </div>
    </div>
</x-project-layout>
