<x-filament::input.wrapper
    prefix-icon="heroicon-m-magnifying-glass"
>
    <x-filament::input
        type="search"
        wire:model.live.debounce.300ms="tableSearch"
        placeholder="Pesquisar Consultor"
    />
</x-filament::input.wrapper>
