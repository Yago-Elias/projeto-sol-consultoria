@php
    $filteredUsers = $this->getFilteredTableQuery()->get();
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 col-span-full">
    @forelse($filteredUsers as $user)
        <x-filament::section>
            <a href="/users/{{ $user['id'] }}" class="flex flex-row justify-between my-auto gap-2">
                <aside class="flex flex-row gap-x-4 my-auto">
                    <x-filament::avatar
                        :src="filament()->getUserAvatarUrl($user)"
                        :alt="'imagem de '.$user['name']"
                        :size="'lg'"
                        :attributes="
                            \Filament\Support\prepare_inherited_attributes($attributes)
                                ->class(['fi-user-avatar'])
                        "
                    />
                    <span class="my-auto text-base font-semibold">{{ $user['name'] }}</span>
                </aside>
                <div class="flex flex-col gap-2">
                    <span class="my-auto">{{ count($user['projects']) + count($user['managedProjects']) }} Projetos Ativos</span>
                    <div class="flex flex-row gap-2 justify-end">
                        @foreach($user['expertises'] as $expertise)
                            <x-filament::badge class="my-auto">{{ $expertise['expertise'] }}</x-filament::badge>
                        @endforeach
                    </div>
                </div>
            </a>
        </x-filament::section>
    @empty
        <x-filament::empty-state class="col-span-full">
            <x-slot name="heading">
                Sem Consultores
            </x-slot>
            <x-slot name="description">
                Clique no botão <span class="underline text-primary-600">Cadastrar</span> para cadastrar um consultor
            </x-slot>
        </x-filament::empty-state>
    @endforelse
</div>
