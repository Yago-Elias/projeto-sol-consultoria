<x-filament::section class="col-span-6 w-100 m-6">
    <a href="{{ route('filament.admin.resources.projects.view', $project->id) }}">
        <div class="flex justify-between my-4">
            <div class="text-xl font-bold">
                {{ $project->name }}
            </div>
            <div>
                <x-filament::badge
                    color="success"
                    icon="heroicon-o-check"
                    icon-position="after"
                >
                    Em dia
                </x-filament::badge>
            </div>
        </div>
        <hr class="border border-gray-900/30">
        <div class="text-md leading-7 my-2 text-gray-600">
            <p>
                {{ $project->description }}
            </p>
            <span>
                <strong>Prazo Final:</strong> {{ $project->end_date->format('d/m/Y') }}
            </span>
            <br>
            <span>
                <strong>Gerente:</strong> {{ $project->manager->name }}
            </span>
        </div>
        <div class="flex flex-row my-4 text-gray-600 text-md gap-2">
            <span>Progresso</span>
            @include('filament.resources.projects.partials.progress', ['percent' => 30])
            <span>30%</span>
        </div>
        <hr class="border border-gray-900/30 my-4">
        <div class="grid grid-cols-3 gap-4">

            {{-- Badge Tarefas Pendentes --}}
            <div class="grid grid-cols-4 rounded-lg border border-warning-800 p-2 bg-warning-100">
                <div class="col-span-3 content-center text-center">
                    <div class="text-2xl font-bold text-primary-900">
                        8
                    </div>
                    <div class="text-primary-800 text-sm">Tarefas Pendentes</div>
                </div>
                <div class="col-span-1 text-primary-900">
                    <x-filament::icon icon="heroicon-o-exclamation-triangle" />
                </div>
            </div>

            {{-- Badge Tarefas Atrasadas --}}
            <div class="grid grid-cols-4 rounded-lg border border-danger-800 p-2 bg-danger-100">
                <div class="col-span-3 content-center text-center">
                    <div class="text-2xl font-bold text-danger-900">
                        1
                    </div>
                    <div class="text-danger-800 text-sm">Tarefas Atrasadas</div>
                </div>
                <div class="col-span-1 text-danger-900">
                    <x-filament::icon icon="heroicon-o-exclamation-circle" />
                </div>
            </div>

            {{-- Badge Margen de Lucro --}}
            <div class="grid grid-cols-4 rounded-lg border border-success-800 p-2 bg-success-100">
                <div class="col-span-3 content-center text-center">
                    <div class="text-2xl font-bold text-success-900">
                        1
                    </div>
                    <div class="text-success-800 text-sm">Tarefas Atrasadas</div>
                </div>
                <div class="col-span-1 text-success-900">
                    <x-filament::icon icon="heroicon-s-chart-bar" />
                </div>
            </div>
        </div>
    </a>
</x-filament::section>
