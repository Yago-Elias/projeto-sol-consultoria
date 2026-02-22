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
    <a href="/my-profile" class='user-info'>
        <aside>
            <x-filament::avatar
                :src="$src"
                :alt="$alt"
                :attributes="
                    \Filament\Support\prepare_inherited_attributes($attributes)
                        ->class(['fi-user-avatar border border-(--neutro-3) min-w-8'])
                "
            />
        </aside>
        <div class='info'>
            <p class='user-name'>{{ $name }}</p>
            <p class='user-position'>{{ $role }}</p>
        </div>
    </a>
    <div class="flex gap-4">
        @can('settings', \App\Models\User::class)
            {{ \Filament\Actions\Action::make('settings')
                ->url('/settings')
                ->icon('heroicon-o-cog-8-tooth')
                ->iconButton()
                ->size('xl')
                ->extraAttributes([
                    'class' => 'my-auto p-2 text-(--escuro-1) hover:text-(--claro-1)'
                ]) }}
        @endcan
        <aside class="w-full">
            {{ \Filament\Actions\Action::make('logout')
                ->url(filament()->getLogoutUrl())
                ->postToUrl()
                ->label('Sair')
                ->icon('heroicon-o-arrow-left-start-on-rectangle') }}
        </aside>
    </div>
</div>
