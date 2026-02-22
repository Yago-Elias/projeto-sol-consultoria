<x-filament-panels::page>
    <container class="grid md:grid-cols-2 gap-4">
        <div class="flex flex-col col-span-1 gap-4">
            <h1 class="font-bold text-xl">Informações financeiras</h1>
            <livewire:payment-types-table/>
            <h2 class="fi-header-subheading">Parcelamento máximo de projetos</h2>
            @php
                $config = \App\Models\Configuration::query()->first();
            @endphp
            <x-filament::input.wrapper>
                <div class="flex justify-between py-2 px-4">
                    <p>{{ $config['max_installments'] }} vezes</p>
                    <livewire:max-installment-form :config="$config" />
                </div>
            </x-filament::input.wrapper>
        </div>
        <div class="flex flex-col col-span-1 gap-4">
            <h1 class="font-bold text-xl">Cargos de usuários</h1>
            <livewire:roles-table/>
        </div>
    </container>
</x-filament-panels::page>
