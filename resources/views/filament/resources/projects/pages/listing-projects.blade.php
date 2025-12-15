<x-filament-panels::page>
<div class="flex justify-evenly">
    <x-filament::section class="grid w-100">
        <div class="flex justify-between my-4">
            <div>
                <span class="text-xl font-bold">
                    Projeto 1
                </span>
            </div>
            <div>
                <x-filament::badge color="success" icon="heroicon-o-check" icon-position="after">
                    Em dia
                </x-filament::badge>
            </div>
        </div>
        <hr class="border border-gray-900/30">
        <div class="text-md leading-7 my-2 text-gray-600">
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
            <span>
                <strong>Prazo Final:</strong> 01/01/2026
            </span>
            <br>
            <span>
                <strong>Gerente:</strong> Consultor
            </span>
        </div>
        <div class="my-4">
            <strong>Progresso</strong> *******************************
        </div>
        <hr class="border border-gray-900/30">
        <div class="flex grid grid-flow-col grid-rows-3 my-4 gap-x-4">
            
            {{-- Badge Tarefas Pendentes --}}
            <div class="flex grid-cols-3 rounded-lg border border-warning-800 row-span-3 p-2 bg-warning-100">
                <div class="grid col-span-2 content-center text-center">
                    <span class="text-2xl font-bold text-primary-900">
                        8
                    </span>
                    <span class="text-primary-800 text-sm">Tarefas Pendentes</span>
                </div>
                <div class="grid col-span text-primary-900">
                    <x-filament::icon icon="heroicon-o-exclamation-triangle" />
                </div>
            </div>

            {{-- Badge Tarefas Atrasadas --}}
            <div class="flex grid-cols-3 rounded-lg border border-danger-800 row-span-3 p-2 bg-danger-100">
                <div class="grid col-span-2 content-center text-center">
                    <span class="text-2xl font-bold text-danger-900">
                        1
                    </span>
                    <span class="text-danger-800 text-sm">Tarefas Atrasadas</span>
                </div>
                <div class="grid col-span text-danger-900">
                    <x-filament::icon icon="heroicon-o-exclamation-circle" />
                </div>
            </div>

            {{-- Badge Margen de Lucro --}}
            <div class="flex grid-cols-3 rounded-lg border border-success-800 row-span-3 p-2 bg-success-100">
                <div class="grid col-span-2 content-center text-center">
                    <span class="text-2xl font-bold text-success-900">
                        52%
                    </span>
                    <span class="text-success-800 text-sm min-w-16">Margem de Lucro</span>
                </div>
                <div class="grid col-span text-success-900">
                    <x-filament::icon icon="heroicon-s-chart-bar" />
                </div>
            </div>
        </div>
    </x-filament::section>
</div>

</x-filament-panels::page>
