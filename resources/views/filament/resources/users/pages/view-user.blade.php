<x-filament::section>
    <x-slot name="heading">
        Informações
    </x-slot>

    <div class="flex flex-row gap-8">
        <div class="min-w-40 my-auto flex flex-col gap-y-2">
            <x-filament::avatar class="w-40 h-40"
                :src="filament()->getUserAvatarUrl($user)"
                :alt="'imagem de '.$user['name']"
                :attributes="
                    \Filament\Support\prepare_inherited_attributes($attributes)
                        ->class(['fi-user-avatar'])
                "
            />
            <p class="w-full text-center font-bold">{{ $user['name'] }}</p>
        </div>
        <aside class="grid grid-cols-2 w-full gap-4">
            <div class="flex flex-col gap-1">
                <strong>Cargo</strong>
                <p class="p-2 rounded-lg border border-(--neutro-1)">{{ $user['role']['role'] }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <strong>Salário</strong>
                <p class="p-2 rounded-lg border border-(--neutro-1)">{{ $user['salary'] }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <strong>Telefone</strong>
                <p class="p-2 rounded-lg border border-(--neutro-1)">{{ $user['telephone'] }}</p>
            </div>
            <div class="flex flex-col gap-1">
                <strong>Email</strong>
                <p class="p-2 rounded-lg border border-(--neutro-1)">{{ $user['email'] }}</p>
            </div>
            <div class="flex flex-col gap-1 col-span-full">
                <strong>Áreas de Expertise</strong>
                <div class="flex gap-2">
                    @foreach($user['expertises'] as $expertise)
                        <x-filament::badge>{{ $expertise['expertise'] }}</x-filament::badge>
                    @endforeach
                </div>
            </div>

        </aside>
    </div>
</x-filament::section>
