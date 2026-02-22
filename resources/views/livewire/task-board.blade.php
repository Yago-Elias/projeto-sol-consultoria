@php
    $tasks = $this->getFilteredTableQuery()->get();
@endphp

<ul class="kanban-column h-100">
    @forelse($tasks as $task)
        <li wire:key="{{ $task->id }}" data-id="{{ $task->id }}">
            <span class="handle" style="cursor: grab;">☰</span>
            {{ $task['title'] }}
        </li>
    @empty
        <x-filament::empty-state>
            <x-slot name="heading">
                Sem Tarefas
            </x-slot>
        </x-filament::empty-state>
    @endforelse
</ul>
