<x-filament-panels::page>
    <div class="grid grid-cols-12">
        @forelse ($projects as $project)
        <x-project-card :project="$project"/>
        @empty
        <div class="col-span-full">
            <x-filament::empty-state>
                <x-slot name="heading">
                    Sem projetos cadastrados
                </x-slot>
                <x-slot name="description">
                    Clique no botão <span class="underline text-primary-600">Novo Projeto</span> para criar um projeto
                </x-slot>
            </x-filament::empty-state>
        </div>
        @endforelse
    </div>
</x-filament-panels::page>
