@php
    $circumference = 90 * pi();
    $offset = (1 - $percentage / 100) * $circumference;
@endphp

<div class="flex flex-row gap-6">
    <div class="inline-flex items-center justify-center relative">
        <svg
            width="100"
            height="100"
            class="transform -rotate-90"
        >
            {{-- Círculo de fundo --}}
            <circle
                cx="50%"
                cy="50%"
                r="45"
                stroke-width="10"
                class="fill-none stroke-(--claro-3)"
            />

            {{-- Círculo de progresso --}}
            <circle
                cx="50%"
                cy="50%"
                r="45"
                stroke-width="10"
                stroke-dasharray="{{ $circumference }}"
                stroke-dashoffset="{{ $offset }}"
                stroke-linecap="round"
                class="fill-none stroke-(--cor-base) transition-all duration-500 ease-out"
            />
        </svg>

        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-2xl font-bold text-gray-700">{{ $percentage }}%</span>
        </div>
    </div>
    <div class="my-auto flex flex-col gap-4">
        <x-filament::badge
            color="success"
            icon="heroicon-o-check"
            icon-position="after"
            class="w-fit"
        >
            Em dia
        </x-filament::badge>
        <h1 class="font-semibold text-xl">Prazo Final: {{ date_format($endDate, 'd/m/Y') }}</h1>
    </div>
</div>
