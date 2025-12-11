<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\ProgressChart;
use Filament\Enums\UserMenuPosition;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Pages\DashboardPage;
use App\Filament\Pages\LoginPage;
use App\Filament\Widgets\InfoBox;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->darkMode(false)
            ->id('admin')
            ->path('admin')
            ->login(LoginPage::class)
            ->passwordReset()
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->brandLogo(asset('images/logo.svg'))
            ->brandLogoHeight('2em')
            ->renderHook(PanelsRenderHook::TOPBAR_END,
                        fn () => Blade::render('<p class="logo-name">Sol Consultorias</p><span style="width: 2em;"></span>'))
            ->userMenu(position: UserMenuPosition::Sidebar)
            ->renderHook(PanelsRenderHook::SIDEBAR_START,
                        fn () => view('components.sidebar-new-project'))
            ->userMenu(false)
            ->renderHook(PanelsRenderHook::SIDEBAR_FOOTER,
                        fn () => view('components.user-menu'))
            ->renderHook(PanelsRenderHook::BODY_END,
                        fn () => Blade::render('<p class="footer">Sol Consultorias &copy; 2025</p>'))
            ->colors([
                'primary' => '#3b250a',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                DashboardPage::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                InfoBox::class,
                ProgressChart::class
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
