@php
    $circumference = 70 * pi();
    $offset = (1 - $percentage / 100) * $circumference;
@endphp

<div class="flex flex-row gap-6">
    <div class="inline-flex items-center justify-center relative">
        <svg
            width="80"
            height="80"
            class="transform -rotate-90"
        >
            {{-- Círculo de fundo --}}
            <circle
                cx="50%"
                cy="50%"
                r="35"
                stroke-width="7"
                class="fill-none stroke-(--claro-3)"
            />

            {{-- Círculo de progresso --}}
            <circle
                cx="50%"
                cy="50%"
                r="35"
                stroke-width="7"
                stroke-dasharray="{{ $circumference }}"
                stroke-dashoffset="{{ $offset }}"
                stroke-linecap="round"
                class="fill-none stroke-(--cor-base) transition-all duration-500 ease-out"
            />
        </svg>

        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-xl font-bold text-(--neutro-3)">{{ round($percentage) }}%</span>
        </div>
    </div>
    <div class="my-auto flex flex-col gap-4">
        <x-filament::badge
            color="success"
            icon="heroicon-o-check"
            icon-position="after"
            class="w-fit"
            font-size="lg"
        >
            Em dia
        </x-filament::badge>
        <h1 class="font-semibold text-xl text-(--neutro-3)">Prazo Final: {{ date_format($endDate, 'd/m/Y') }}</h1>
    </div>
</div>
