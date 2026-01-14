<x-project-layout activeTab="{{ $activeTab }}" :urls="$urls">
    Detalhes
    {{ \Filament\Actions\EditAction::make()->url("/projects/{$project['id']}/edit") }}
</x-project-layout>
