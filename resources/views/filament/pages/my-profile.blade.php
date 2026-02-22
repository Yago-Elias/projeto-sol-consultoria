<x-filament-panels::page>
    @include('filament.resources.users.pages.view-user', ['user' => filament()->auth()->user(), 'attributes' => $this->getAttributes()])
</x-filament-panels::page>
