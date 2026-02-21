<x-filament-panels::page>
    <container class="grid md:grid-cols-2 gap-4">
        <div class="flex flex-col col-span-1 gap-4">
            <h1 class="font-bold text-xl">Cargos de usuários</h1>
            <livewire:roles-table/>
        </div>
        <div class="flex flex-col col-span-1 gap-4">
            <h1 class="font-bold text-xl">Informações financeiras</h1>
            <livewire:payment-types-table/>
        </div>
    </container>
</x-filament-panels::page>
