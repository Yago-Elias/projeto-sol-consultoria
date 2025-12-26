<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    @forelse($users as $user)
        <x-filament::section>
            <a class="flex flex-row justify-between" href="/users/{{ $user['id'] }}">
                <aside class="flex flex-row gap-x-4">
                    <x-filament::avatar
                        :src="$user['image']"
                        :alt="'imagem de '.$user['name']"
                        :attributes="
                            \Filament\Support\prepare_inherited_attributes($attributes)
                                ->class(['fi-user-avatar'])
                        "
                    />
                    <span class="my-auto text-base font-semibold">{{ $user['name'] }}</span>
                </aside>
                <div class="flex flex-row gap-2">
                    @foreach($user['expertises'] as $expertise)
                        <x-filament::badge class="my-auto">{{ $expertise['expertise'] }}</x-filament::badge>
                    @endforeach
                </div>
                <span class="my-auto">{{ count($user['projects']) }} Projetos Ativos</span>
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
