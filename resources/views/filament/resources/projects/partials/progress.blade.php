<div class="flex gap-2 items-center text-gray-600 w-full">
    <span>Progresso</span>
    <div class="flex flex-grow">
        <div class="flex bg-primary-500 h-1.75 rounded-full transition-all duration-1000" style="width: {{ $percent }}%"></div>
        <div class="flex flex-grow bg-primary-200 h-1.75 rounded-full items-center justify-end"></div>
    </div>
    <span>{{ $percent }}%</span>
</div>
