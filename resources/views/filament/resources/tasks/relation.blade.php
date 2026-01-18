<div>
    @forelse($ownerRecord['boards'] as $board)
        <x-filament::section>
            <x-slot name="heading">
                {{ $board['nome'] }}
            </x-slot>

            @forelse($board['tasks'] as $task)
                <p>{{ $task['title'] }}</p>
            @empty
                <x-filament::empty-state>
                    <x-slot name="heading">
                        Crie tarefas
                    </x-slot>
                </x-filament::empty-state>
            @endforelse
        </x-filament::section>
    @empty
        <x-filament::empty-state>
            <x-slot name="heading">
                Ainda não há quadros de tarefas
            </x-slot>
            <x-slot name="description">
                Clique no botão <span class="underline text-primary-600">Novo Quadro</span> para criar um quadro e criar tarefas
            </x-slot>
        </x-filament::empty-state>
    @endforelse
</div>

