<?php

namespace Depotwarehouse\OAuth2\Client\Twitch\FrameworkIntegration\Laravel;

use Depotwarehouse\OAuth2\Client\Twitch\Provider\Twitch;
use Illuminate\Support\ServiceProvider;
use Config;

class TwitchOAuth2ServiceProvider extends ServiceProvider
{

    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->package('depotwarehouse/oauth2-twitch', null, __DIR__);
        $this->app->bind(Twitch::class, function() {
            return new Twitch([
                'clientId' => Config::get('oauth2-twitch::clientId'),
                'clientSecret' => Config::get('oauth2-twitch::clientSecret'),
                'redirectUri' => Config::get('oauth2-twitch::redirectUri')
            ]);
        });
    }
}
