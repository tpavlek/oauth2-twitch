Twitch provider for league/oauth2-client
=========================================

This is a package to integrate Battle.net authentication with the [OAuth2 client library](https://github.com/thephpleague/oauth2-client) by
[The League of Extraordinary Packages](http://thephpleague.com).

To install, use composer:

```bash
composer require depotwarehouse/oauth2-twitch
```

Usage is the same as the league's OAuth client, using `\Depotwarehouse\OAuth2\Client\Twitch\Provider\Twitch` as the provider.
For example:

```php
$provider = new \Depotwarehouse\OAuth2\Client\Twitch\Provider\Twitch([
    'clientId' => "YOUR_CLIENT_ID",
    'clientSecret' => "YOUR_CLIENT_SECRET",
    'redirectUri' => "http://your-redirect-uri"
]);
```

You can also optionally add a `scopes` key to the array passed to the constructor. The available scopes are documented
on the [Twitch API Documentation](https://github.com/justintv/Twitch-API/blob/master/authentication.md).

> Note: The provider uses the "user_read" scope by default. If you pass other scopes, and want the ->getUserDetails() method
to work, you will need to ensure the "user_read" scope is used.

```php
if (isset($_GET['code']) && $_GET['code']) {
    $token = $this->provider->getAccessToken("authorizaton_code", [
        'code' => $_GET['code']
    ]);

    // Returns an instance of Depotwarehouse\OAuth2\Client\Twitch\Entity\TwitchUser
    $user = $this->provider->getUserDetails($token);
    
    $user->getDisplayName();
    $user->getId()
    $user->getType();
    $user->getBio();
    $user->getEmail();
    $user->getPartnered();
```
