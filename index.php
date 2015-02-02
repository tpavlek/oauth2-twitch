<?php

require 'vendor/autoload.php';

$provider = new \Depotwarehouse\OAuth2\Client\Twitch\Provider\Twitch([
'clientId' => "bqzmhb7560sdxx7ixll05hmo53taxwp",
'clientSecret' => "l8z2b6c0ov025fhg1s14v3eosfdut4r",
'redirectUri' => "http://localhost:8000"
]);

if (isset($_GET['code']) && $_GET['code']) {
    $token = $provider->getAccessToken("authorization_code", [
        'code' => $_GET['code']
    ]);

    $user = $provider->getUserDetails($token);
    var_dump($user);


} else {
    header('Location: ' . $provider->getAuthorizationUrl());
}
