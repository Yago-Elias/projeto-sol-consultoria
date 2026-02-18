{{-- @dd($record) --}}

<x-filament-panels::page>
    @if(filament()->auth()->user()['profile']['project_manager'] & \App\Permissions::EDIT)
        <div>
            {{\Filament\Actions\Action::make('Editar Projeto')
                ->url("/projects/{$this->record['id']}/edit")
                ->icon(\Filament\Support\Icons\Heroicon::OutlinedPencilSquare)
                ->extraAttributes([
                    'class' => 'w-fit'
            ])}}
        </div>
    @endif
    <x-filament::section>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="flex items-start">
                <div class="w-full max-w-md mx-auto bg-gray-200 rounded-lg overflow-hidden aspect-video">
                    @if($record->image)
                        <img class="w-full h-full object-cover" src="{{ $record->image }}" alt="imagem projeto">
                    @endif
                </div>
            </div>

            <div class="flex flex-col space-y-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $record->company_name }}</h2>
                    <span class="text-gray-500">{{ $record->company_email }}</span>
                </div>

                @if($record->description)
                    <div class="text-gray-600 leading-relaxed">
                        <span>{{ $record->description }}</span>
                    </div>
                @endif

                <div class="space-y-2">
                    <div>
                        <span class="text-gray-700">Data de Início:</span>
                        <span class="text-gray-900 ml-2">{{ $record->start_date }}</span>
                    </div>
                    <div>
                        <span class="text-gray-700">Prazo final:</span>
                        <span class="text-gray-900 ml-2">{{ $record->end_date }}</span>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>

    <x-filament::section class="mt-6">
        <div class="grid gird-cols-2 md:grid-cols-4 gap-6">
            @forelse ($record->collaborators as $user)
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full gb-gray-200 overflow-hidden flex items-center justify-center">
                            @if($user->getFilamentAvatarUrl())
                                <img class="w-full h-full object-cover" src="{{ $user->getFilamentAvatarUrl() }}" alt="{{ $user->name }}">
                            @else
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col min-w-0">
                        <span class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</span>
                        <span class="text-xs text-gray-500 truncate">{{ $user->role->role }}</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 py-4">
                    Nenhum colaborador atribuído
                </div>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-panels::page>
