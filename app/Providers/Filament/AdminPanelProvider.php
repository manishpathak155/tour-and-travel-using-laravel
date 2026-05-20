<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationGroup;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $brandLogo = setting('brand_logo');
        $brandLogoDark = setting('brand_logo_dark');
        $favicon = setting('site_favicon');
        $primaryColor = setting('admin_primary_color', '#0D1B4B');

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName(setting('site_name', 'Altivaro Treks'))
            ->brandLogo($brandLogo ? asset('storage/' . $brandLogo) : asset('images/altivaro-logo.png'))
            ->darkModeBrandLogo($brandLogoDark ? asset('storage/' . $brandLogoDark) : null)
            ->brandLogoHeight('2.5rem')
            ->favicon($favicon ? asset('storage/' . $favicon) : asset('images/favicon.ico'))
            ->colors([
                'primary' => Color::hex($primaryColor),
            ])
            ->navigationGroups([
                NavigationGroup::make('Tour Management')->icon('heroicon-o-map'),
                NavigationGroup::make('Booking Management')->icon('heroicon-o-clipboard-document-list'),
                NavigationGroup::make('User Management')->icon('heroicon-o-users'),
                NavigationGroup::make('Content Management')->icon('heroicon-o-document-text'),
                NavigationGroup::make('Finance')->icon('heroicon-o-banknotes'),
                NavigationGroup::make('System Settings')->icon('heroicon-o-cog-6-tooth'),
            ])
            ->sidebarCollapsibleOnDesktop()
            ->darkMode(false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
