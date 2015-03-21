<?php

namespace Depotwarehouse\OAuth2\Client\Twitch\FrameworkIntegration\Laravel;

use Depotwarehouse\OAuth2\Client\Twitch\Provider\Twitch;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\ServiceProvider;

class TwitchOAuth2ServiceProvider extends ServiceProvider
{

    protected $defer = false;

    public function boot(Repository $config)
    {
        $this->publishes([
            __DIR__."/config/config.php" => config_path('oauth2-twitch.php')
        ]);

        $this->mergeConfigFrom(__DIR__."/config/config.php", 'oauth2-twitch');

        $this->app->bind(Twitch::class, function() use ($config) {
            $twitch = new Twitch([
                'clientId' => $config->get('oauth2-twitch.clientId'),
                'clientSecret' => $config->get('oauth2-twitch.clientSecret'),
                'redirectUri' => $config->get('oauth2-twitch.redirectUri')
            ]);
            return $twitch;
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
