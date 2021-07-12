<?php

namespace Takwasoft\DataAdmin;

use File;
use Illuminate\Support\ServiceProvider;

class DataAdminServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $this->publishes([
            __DIR__ . '/../publish/Middleware/' => app_path('Http/Middleware'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/migrations/' => database_path('migrations'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/Models/' => app_path('Models'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/Controllers/' => app_path('Http/Controllers'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/resources/' => base_path('resources'),
        ]);

        $this->publishes([
            __DIR__ . '/../publish/crudgenerator.php' => config_path('crudgenerator.php'),
        ]);

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/data-admin'),
        ], 'views');

        $this->loadViewsFrom(__DIR__ . '/views', 'data-admin');

        $menus = [];
        if (File::exists(base_path('resources/data-admin/menus.json'))) {
            $menus = json_decode(File::get(base_path('resources/data-admin/menus.json')));
            view()->share('DataAdminMenus', $menus);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(
            'Takwasoft\DataAdmin\DataAdminCommand'
        );

        $this->app->bind('Setting', \Takwasoft\DataAdmin\Setting::class);
    }
}
