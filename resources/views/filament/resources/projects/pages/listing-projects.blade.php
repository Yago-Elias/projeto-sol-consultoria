<x-filament-panels::page>
    <div class="flex mb-4 justify-center">
        <div class="w-lg">
            <x-filament::input.wrapper>
                <x-filament::input
                    type="text"
                    wire:model.live.debounce.400ms="search"
                    placeholder="Buscar projetos..."
                />
            </x-filament::input.wrapper>
        </div>
    </div>
    <div class="grid grid-cols-12">
        @forelse ($this->getProjects() as $project)
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
    <div class="mt-6">
        <x-filament::pagination 
            :paginator="$this->getProjects()"
            :page-options="[8, 14, 20, 30, 50]"
            current-page-option-property="perPage"
        />
    </div>
</x-filament-panels::page>
