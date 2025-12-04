@props([
    'user' => filament()->auth()->user(),
])

@php
    $src = filament()->getUserAvatarUrl($user);
    $name = filament()->getUserName($user);
    $alt = __('filament-panels::layout.avatar.alt', ['name' => $name]);
@endphp

<div class="user-menu p-4" xmlns:x-filament="http://www.w3.org/1999/html">
    <div class='user-info flex-column gap-2'>
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
        <div class='info w-full'>
            <p class='user-name'>{{ $name }}</p>
            <p class='user-postion'>Administrador</p>
        </div>
    </div>
    {{ \Filament\Actions\Action::make('logout')->url(filament()->getLogoutUrl())->postToUrl()->label('Sair')->icon('heroicon-o-arrow-left-start-on-rectangle') }}
</div>
