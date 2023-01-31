<?php

namespace Ae3\JasperServer\Laravel\Integrator\app\Providers;

use Ae3\JasperServer\Laravel\Integrator\app\Services\Contracts\JasperServerRequestServiceContract;
use Ae3\JasperServer\Laravel\Integrator\app\Services\JasperServerRequestService;
use Illuminate\Support\ServiceProvider;
use Jaspersoft\Client\Client;

class IntegratorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'jasperserver-laravel-integrator');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/config.php' => config_path('jasperserver-laravel-integrator.php'),
            ], 'config');
        }

        $this->app->bind(JasperServerRequestServiceContract::class, function ($app) {
            $config = $app['config']['jasperserver-laravel-integrator']['server'];

            $client = $this->app->make(Client::class, [
                'serverUrl' => $config['uri'],
                'username' => $config['username'],
                'password' => $config['password']
            ]);

            return new JasperServerRequestService($client);
        });
    }
}
