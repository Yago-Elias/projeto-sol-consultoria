<div class="w-full flex flex-row gap-2 px-4">
    <div class='w-full h-3/4 bg-(--neutro-2) rounded-md'>
        <div class='h-full bg-(--cor-base) rounded-md'
             style="width: {{ $record['Progresso'] }}%"></div>
    </div>
    <span><strong>{{ $record['Progresso'] }}%</strong></span>
</div>
