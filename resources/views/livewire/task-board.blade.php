@php
    $tasks = $this->getFilteredTableQuery()->get();
@endphp

<ul class="kanban-column flex flex-col gap-4 h-full min-h-10">
    @forelse($tasks as $task)
        <li wire:key="{{ $task->id }}" data-id="{{ $task->id }}"
            class="flex gap-4 justify-between rounded pr-2"
            @click="
                if ($event.target.closest('[data-modal-close], button[x-on\\:click*=close], [wire\\:click*=close]')) return;
                $wire.mountTableAction('view', {{ $task->id }})"
        >
            <span class="handle my-auto" style="cursor: grab;">
                <x-filament::icon-button
                    icon="heroicon-o-bars-3"
                    color="gray"
                />
            </span>
            <div class="w-full flex flex-col">
                <span class="text-sm text-light text-(--neutro-1)">
                    {{ $task['title'] }}
                </span>
                @if ($task->overdue())
                    <span class="text-xs text-danger-600">
                        Até {{ date_format($task['due_date'], 'd/m') }}
                    </span>
                @elseif ($task['status'] != 'APROVADA')
                    <span class="text-xs text-gray-500">
                        Até {{ date_format($task['due_date'], 'd/m') }}
                    </span>
                @endif
            </div>
            <div class="mx-2 my-auto">
                {{ $this->table->getRecordActions()[0]->record($task) }}
                <x-filament-actions::modals/>
            </div>
        </li>
    @empty
        <div class="flex justify-center gap-2 items-center">
            <x-filament::icon-button
                icon="heroicon-o-x-mark"
                color="gray"
            />
            <span class="text-base font-bold text-(--neutro-1)">
                Sem Tarefas
            </span>
        </div>
    @endforelse
</ul>
