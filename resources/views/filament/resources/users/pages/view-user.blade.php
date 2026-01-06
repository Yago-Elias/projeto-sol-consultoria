@php
    $money = NumberFormatter::create('pt_BR', NumberFormatter::CURRENCY);
@endphp

<div>
    <x-filament::section>
        <x-slot name="heading">
            Informações
        </x-slot>

        <div class="grid md:grid-cols-4 gap-8">
            <div class="md:col-span-1 my-auto flex flex-col gap-y-2">
                <x-filament::avatar class="w-40 h-40 mx-auto"
                    :src="filament()->getUserAvatarUrl($user)"
                    :alt="'imagem de '.$user['name']"
                    :attributes="
                        \Filament\Support\prepare_inherited_attributes($attributes)
                            ->class(['fi-user-avatar'])
                    "
                />
                <p class="w-full text-center font-bold">{{ $user['name'] }}</p>
            </div>
            <aside class="grid md:grid-cols-2 w-full gap-4 md:col-span-3">
                <div class="flex flex-col gap-1">
                    <strong>Cargo</strong>
                    <x-filament::input.wrapper>
                        <p class="p-2">{{ $user['role']['role'] }}</p>
                    </x-filament::input.wrapper>
                </div>
                <div class="flex flex-col gap-1">
                    <strong>Salário</strong>
                    <x-filament::input.wrapper>
                        <p class="p-2">{{ $money->format($user['salary']) }}</p>
                    </x-filament::input.wrapper>
                </div>
                <div class="flex flex-col gap-1">
                    <strong>Telefone</strong>
                    <x-filament::input.wrapper>
                        <p class="p-2">{{ $user['telephone'] }}</p>
                    </x-filament::input.wrapper>
                </div>
                <div class="flex flex-col gap-1">
                    <strong>Email</strong>
                    <x-filament::input.wrapper>
                        <p class="p-2">{{ $user['email'] }}</p>
                    </x-filament::input.wrapper>
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

    <h1 class="text-xl font-bold my-6">Projetos como gerente</h1>
    @foreach($user['managedProjects'] as $project)
        <p>{{ $project['name'] }}</p>
    @endforeach

    <h1 class="text-xl font-bold my-6">Outros projetos</h1>
    @foreach($user['projects'] as $project)
        <p>{{ $project['name'] }}</p>
    @endforeach
</div>
