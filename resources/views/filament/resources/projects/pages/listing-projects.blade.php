<x-filament-panels::page>
    <div class="grid grid-cols-12">
        @forelse ($projects as $project)
        <x-filament::section class="col-span-6 w-100 m-6">
            <a href="{{ route('filament.admin.resources.projects.edit', $project->id) }}">
                <div class="flex justify-between my-4">
                    <div>
                        <span class="text-xl font-bold">
                            {{ $project->name }}
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
                <div class="my-4">
                    @include('filament.resources.projects.partials.progress', ['percent' => 30])
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
            </a>
        </x-filament::section>
        @empty
        <x-filament::empty-state>
            <x-slot name="heading">
                Sem projetos cadastrados
            </x-slot>
            <x-slot name="description">
                Clique no botão <span class="underline text-primary-600">Novo Projeto</span> para criar um projeto
            </x-slot>
        </x-filament::empty-state>
        @endforelse
</div>
</x-filament-panels::page>
