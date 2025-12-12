@php
    $projetos = $this->getViewData();
@endphp

<table class="w-full h-full">
    <thead class="text-base w-full">
        <tr class="px-auto py-4 block">
            <th class="w-1/8">Tempo restante</th>
            <th class="w-1/8">Custos</th>
            <th class="w-1/8">Receita</th>
            <th class="w-1/8">Lucro</th>
        </tr>
    </thead>

    <tbody class="px-auto py-6 block">
        @foreach($projetos as $projeto)
            <tr class="block gap-auto text-center">
                <td class="w-1/100">{{ $projeto[0] }}</td>
                <td class="w-1/100 text-danger-600">{{ $projeto[1] }}</td>
                <td class="w-1/100 text-success-600">{{ $projeto[2] }}</td>
                <td class="w-1/100">{{ $projeto[3] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
