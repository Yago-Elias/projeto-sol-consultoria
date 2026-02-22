<div class="flex justify-between">
    <div class="flex gap-4 items-center">
        <x-filament::icon-button
            icon="heroicon-o-funnel"
            size="xl"
            label="Filtrar tarefas por consultor"
        />
        <x-filament::input.wrapper>
            <x-filament::input.select
                wire:model.live="filterUser" default="all">
                <option value="all">Todos</option>
                @foreach($this->project['collaborators']->pluck('name') as $user)
                    <option value="{{ $user }}">{{ $user }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>
    </div>
    @can('create', [\App\Models\Task::class, $this->project])
        <div>
            {{ $this->createAction }}
            <x-filament-actions::modals />
        </div>
    @endcan
</div>
