@php
    $userPerm = filament()->auth()->user()['profile'];
@endphp

<button disabled="{{ !$userPerm['global_access'] && !$userPerm['manage_projects'] & \App\Permissions::CREATE }}">
    <a href="{{ route('filament.admin.resources.projects.create') }}" class="fi-sidebar-item-btn" id="new-project">
        <x-filament::icon
            icon="heroicon-o-plus"
        />
        <span>Novo Projeto</span>
    </a>
</button>
