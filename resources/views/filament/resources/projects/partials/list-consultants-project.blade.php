<div class="flex grid sm:grid-cols-6 md:grid-cols-9 lg:grid-flow-cols-12 gap-3">
    @forelse ($consultants as $consultant)
    {{-- @dd($consultant) --}}
    <div class="flex justify-evenly min-w-55 p-2 sm:col-span-3 md:col-span-3 lg:col-span-4 xl:col-span-3 rounded-md shadow-md ">
        <div class="min-w-15">
            @if (isset($consultant['image']))
            <img class="rounded-full h-15" src="{{ $consultant['image'] }}">
            @else
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="#7f4300" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            @endif
        </div>
        <div class="flex flex-col justify-center">
            <span class="text-base">
                {{ $consultant['name'] }}
            </span>
            <span class="font-xs text-gray-600">
                {{ $consultant['role'] }}
            </span>
        </div>
        <div class="flex min-w-10 h-10 items-center justify-center rounded-full hover:bg-red-100 transition duration-500">
            <div>
                <x-filament::icon
                    icon="heroicon-o-trash"
                    color="red"
                />
            </div>
        </div>
    </div>
    @empty
    <div class="flex col-span-full">
    <x-filament::empty-state class="flex grow">
        <x-slot name="heading">
            Nenhum consultor no projeto
        </x-slot>

        <x-slot name="description">
            Clique no botão <span class="underline text-primary-600">Adicionar Consultor</span> para adicionar os consultores que irão trabalhar nesse projeto.
        </x-slot>
    </x-filament::empty-state>
    </div>
    @endforelse
</div>