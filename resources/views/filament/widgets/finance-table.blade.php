@php
    $projetos = $this->getViewData();
@endphp

<x-filament-widgets::widget class="fi-wi-table">
    <table class="w-full h-full">
        <thead class="text-base w-full">
            <tr class="px-auto py-4 block">
                <th class="w-1/8">Tempo restante</th>
                <th class="w-1/8">Custos</th>
                <th class="w-1/8">Receita</th>
                <th class="w-1/8">Lucro</th>
            </tr>
        </thead>

        <tbody class="py-8 w-full block">
            @foreach($projetos as $projeto)
                <tr class="py-1 flex">
                    <td class="flex-1 text-center">{{ $projeto[0] }}</td>
                    <td class="flex-1 text-center text-danger-600">{{ $projeto[1] }}</td>
                    <td class="flex-1 text-center text-success-600">{{ $projeto[2] }}</td>
                    <td class="flex-1 text-center">{{ $projeto[3] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-filament-widgets::widget>
