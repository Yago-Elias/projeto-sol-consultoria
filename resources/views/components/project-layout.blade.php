<x-filament-panels::page>
    <x-filament::tabs>
        <x-filament::tabs.item
            :active="$activeTab === 'tab1'"
            :href="'#'"
            tag="a"
        >
            Tarefas
        </x-filament::tabs.item>
        <x-filament::tabs.item
            :active="$activeTab === 'tab1'"
            :href="'#'"
            tag="a"
        >
            Em Aprovação
        </x-filament::tabs.item>
        <x-filament::tabs.item
            :active="$activeTab === 'tab1'"
            :href="'#'"
            tag="a"
        >
            Financeiro
        </x-filament::tabs.item>
        <x-filament::tabs.item
            :active="$activeTab === 'tab1'"
            :href="'#'"
            tag="a"
        >
            Detalhes
        </x-filament::tabs.item>
    </x-filament::tabs>

    {{ $slot }}
</x-filament-panels::page>
