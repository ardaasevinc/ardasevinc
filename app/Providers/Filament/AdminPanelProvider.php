<?php

namespace App\Providers\Filament;

use Filament\Panel;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Filament\Navigation\UserMenuItem;
use Filament\Support\Assets\Js;


use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Models\Setting;


use Filament\View\PanelsRenderHook;
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel

            /*
            |--------------------------------------------------------------------------
            | CORE PANEL
            |--------------------------------------------------------------------------
            */
            ->default()
            ->spa()
            ->id('admin')
            ->path('admin')

            /*
            |--------------------------------------------------------------------------
            | AUTH & SECURITY
            |--------------------------------------------------------------------------
            */
            ->login()
            ->registration(false)
            ->emailVerification(false)
            ->profile()
            ->passwordReset()
            ->authGuard('web')
            

        
            /*
            |--------------------------------------------------------------------------
            | BRANDING
            |--------------------------------------------------------------------------
            */
           ->brandName($settings?->site_name ?? 'Karakter360')
->darkModeBrandLogo(function () {
    $settings = Setting::first();
    return ($settings && $settings->logo_light) 
        ? asset('uploads/' . $settings->logo_light) 
        : asset('logo.svg');
})
->BrandLogo(function () {
    $settings = Setting::first();
    return ($settings && $settings->logo_dark) 
        ? asset('uploads/' . $settings->logo_dark) 
        : asset('logo.svg');
})
->favicon(function () {
    $settings = Setting::first();
    return ($settings && $settings->favicon) 
        ? asset('uploads/' . $settings->favicon) 
        : asset('favicon.svg');
})
->brandLogoHeight('40px')

            /*
            |--------------------------------------------------------------------------
            | UI / UX
            |--------------------------------------------------------------------------
            */
            ->font('Inter')
            ->sidebarWidth('250px')
            ->collapsedSidebarWidth('64px')
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('1000px')
            ->topNavigation(false)
            ->breadcrumbs(true)

            // ->databaseNotifications()
            // ->databaseNotificationsPolling('15s')
            // ->lazyLoadedDatabaseNotifications()
            // ->globalSearch(true)
            // ->globalSearchKeyBindings(['command+k', 'ctrl+k'])

            /*
            |--------------------------------------------------------------------------
            | COLORS & THEME
            |--------------------------------------------------------------------------
            */
            ->colors([
                'primary' => '#202124',
                'gray'    => '#202124',
                'danger'  => '#B4244A',
                'warning' => '#F59E0B',
                'info'    => '#3B82F6',
                'success' => '#5BEB00',
                'badge'  => '#B4244A',
            ])

            /*
            |--------------------------------------------------------------------------
            | DISCOVERY
            |--------------------------------------------------------------------------
            */
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            )

            /*
            |--------------------------------------------------------------------------
            | PAGES
            |--------------------------------------------------------------------------
            */
            ->pages([
                Dashboard::class,
            ])

            /*
            |--------------------------------------------------------------------------
            | WIDGETS
            |--------------------------------------------------------------------------
            */
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])

            /*
            |--------------------------------------------------------------------------
            | USER MENU
            |--------------------------------------------------------------------------
            */
            ->userMenuItems([
                UserMenuItem::make()
                    ->label('Profil')
                    ->url('/ardaasevinc/profile')
                    ->icon('heroicon-o-user'),

                UserMenuItem::make()
                    ->label('Bize Ulaşın')
                    ->url('tel:05326379944')
                    ->icon('heroicon-o-phone')
                    ->sort(999),
            ])

            /*
            |--------------------------------------------------------------------------
            | ASSETS
            |--------------------------------------------------------------------------
            */
            // ->assets([
            //     Js::make('sortable', asset('js/sortable.min.js')),
            // ])

            /*
            |--------------------------------------------------------------------------
            | MIDDLEWARE
            |--------------------------------------------------------------------------
            */
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                // DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                // FilamentShieldPlugin::make(),
               
                
            ])

            /*
            |--------------------------------------------------------------------------
            | AUTH MIDDLEWARE
            |--------------------------------------------------------------------------
            */
            ->authMiddleware([
                Authenticate::class,
            ])

             ->renderHook(
            PanelsRenderHook::BODY_END,
            fn () => view('filament.pages.footer')
        );
    }
}
