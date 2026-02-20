@php
    $tasks = $this->getFilteredTableQuery()->get();
@endphp

<div>
    @foreach($tasks as $task)
        <p>{{ $task['title'] }}</p>
        {{ $this->table->getRecordActions()[0]->record($task) }}
        <x-filament-actions::modals />
    @endforeach
</div>
