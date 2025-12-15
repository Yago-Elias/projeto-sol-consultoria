<div class="flex grid sm:grid-cols-6 md:grid-cols-9 lg:grid-flow-cols-12 gap-3">
    @forelse (($consultants ?? ['']) as $consultant)
    <div class="flex justify-evenly min-w-55 p-2 sm:col-span-3 md:col-span-3 lg:col-span-4 xl:col-span-3 rounded-md shadow-md ">
        <div class="min-w-15">
            <img class="rounded-full" src="https://randomuser.me/api/portraits/thumb/women/75.jpg">
        </div>
        <div class="flex flex-col justify-center">
            <span class="text-base">
                Solange de Andrade
            </span>
            <span class="font-xs text-gray-600">
                Administrador(a)
            </span>
        </div>
        <div class="flex min-w-10 h-10 items-center justify-center rounded-full hover:bg-red-100 transition duration-500">
            <a href="#">
                <x-filament::icon
                    icon="heroicon-o-trash"
                    color="red"
                />
            </a>
        </div>
    </div>
    @empty
    <div class="flex col-span-full">
    <x-filament::empty-state class="flex grow">
        <x-slot name="heading">
            Nenhum consultor no projeto
        </x-slot>

        <x-slot name="description">
            Clique no botão <span class="underline text-primary-600">Adicionar Consultor</span> para adicionar os consultores que irão trabalhar nesse projeto.
        </x-slot>
    </x-filament::empty-state>
    </div>
    @endforelse
</div>