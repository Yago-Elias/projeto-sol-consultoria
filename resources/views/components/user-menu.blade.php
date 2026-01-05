@props([
    'user' => filament()->auth()->user(),
])

@php
    $src = filament()->getUserAvatarUrl($user);
    $name = filament()->getUserName($user);
    $alt = __('filament-panels::layout.avatar.alt', ['name' => $name]);
    $role = $user['role']['role'];
@endphp

<div class="user-menu" xmlns:x-filament="http://www.w3.org/1999/html">
    <div class='user-info'>
        <aside>
            <x-filament::avatar
                :src="$src"
                :alt="$alt"
                :attributes="
                    \Filament\Support\prepare_inherited_attributes($attributes)
                        ->class(['fi-user-avatar'])
                "
            />
        </aside>
        <div class='info'>
            <p class='user-name'>{{ $name }}</p>
            <p class='user-position'>{{ $role }}</p>
        </div>
    </div>
    {{ \Filament\Actions\Action::make('logout')
        ->url(filament()->getLogoutUrl())
        ->postToUrl()
        ->label('Sair')
        ->icon('heroicon-o-arrow-left-start-on-rectangle') }}
</div>
