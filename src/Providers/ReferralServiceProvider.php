<?php

namespace Azuriom\Plugin\Referral\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Illuminate\Support\Facades\View;
use Azuriom\Plugin\Referral\Cards\ReferralViewCard;
use Azuriom\Extensions\Plugin\AdminUserEditComposer;
use Azuriom\Plugin\Referral\Views\Composer\ReferrerUserComposer;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Referral\Middleware\RegisterMiddleware;

class ReferralServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [
        RegisterMiddleware::class,
    ];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [];

    protected array $routeMiddleware = [
    ];
    

    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [
        // User::class => UserPolicy::class,
    ];

    /**
     * Register any plugin services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
    {
        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        $this->app->register(EventServiceProvider::class);

        $this->app['router']->pushMiddlewareToGroup('web', RegisterMiddleware::class);

        View::composer('profile.index', ReferralViewCard::class); 

        if(class_exists(AdminUserEditComposer::class)) {
            View::composer('admin.users.edit', ReferrerUserComposer::class);
        }

        Permission::registerPermissions([
            'referral.manage' => 'referral::messages.permissions.manage',
            'referral.resetdb' => 'referral::messages.permissions.resetdb',
        ]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            //
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array<string, array<string, string>>
     */
    protected function adminNavigation(): array
    {
        return [
            'referral' => [
                'name' => trans('referral::messages.admin.name'),
                'type' => 'dropdown',
                'icon' => 'bi bi-link-45deg',
                'route' => 'referral.admin.*',
                'items' => [
                    'referral.admin.settings' => trans('referral::messages.admin.nav.index'),
                    'referral.admin.rewards' => trans('referral::messages.admin.nav.rewards'),
                    'referral.admin.history' => trans('referral::messages.admin.nav.history'),
                    'referral.admin.statistics' => trans('referral::messages.admin.nav.statistics'),
                ],
                'permission' => 'referral.manage'
            ]
        ];
    }

    /**
     * Return the user navigations routes to register in the user menu.
     *
     * @return array<string, array<string, string>>
     */
    protected function userNavigation(): array
    {
        return [
            //
        ];
    }
}
