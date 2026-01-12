<x-filament-panels::page>
    <x-filament::tabs>
        <x-filament::tabs.item
            :active="$activeTab === 'tarefas'"
            :href="$urls['tarefas']"
            tag="a"
        >
            Tarefas
        </x-filament::tabs.item>
        <x-filament::tabs.item
            :active="$activeTab === 'aprovacao'"
            :href="$urls['aprovacao']"
            tag="a"
        >
            Em Aprovação
        </x-filament::tabs.item>
        <x-filament::tabs.item
            :active="$activeTab === 'financeiro'"
            :href="$urls['financeiro']"
            tag="a"
        >
            Financeiro
        </x-filament::tabs.item>
        <x-filament::tabs.item
            :active="$activeTab === 'detalhes'"
            :href="$urls['detalhes']"
            tag="a"
        >
            Detalhes
        </x-filament::tabs.item>
    </x-filament::tabs>

    {{ $slot }}
</x-filament-panels::page>
