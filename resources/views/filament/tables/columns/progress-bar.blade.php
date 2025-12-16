<div class="w-full flex flex-row gap-2 px-4">
    <div class='w-full h-3/4 bg-(--color-gray-300) rounded-lg my-auto p-0.5'>
        <div class='h-full bg-(--cor-base)/90 rounded-lg my-auto'
             style="width: {{ $record['Progresso'] }}%"></div>
    </div>
    <span><strong>{{ $record['Progresso'] }}%</strong></span>
</div>
