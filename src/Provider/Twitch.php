<?php

namespace Depotwarehouse\OAuth2\Client\Twitch\Provider;

use Depotwarehouse\OAuth2\Client\Twitch\Entity\TwitchUser;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

class Twitch extends AbstractProvider
{

    public $scopeSeparator = ' ';

    public $scopes = [ "user_read" ];

    /**
     * Get the URL that this provider uses to begin authorization.
     *
     * @return string
     */
    public function urlAuthorize()
    {
        return "https://api.twitch.tv/kraken/oauth2/authorize";
    }

    /**
     * Get the URL that this provider users to request an access token.
     *
     * @return string
     */
    public function urlAccessToken()
    {
        return "https://api.twitch.tv/kraken/oauth2/token";
    }

    /**
     * Get the URL that this provider uses to request user details.
     *
     * Since this URL is typically an authorized route, most providers will require you to pass the access_token as
     * a parameter to the request. For example, the google url is:
     *
     * 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token='.$token
     *
     * @param AccessToken $token
     * @return string
     */
    public function urlUserDetails(AccessToken $token)
    {
        return "https://api.twitch.tv/kraken/user?oauth_token=" . $token;
    }

    /**
     * Given an object response from the server, process the user details into a format expected by the user
     * of the client.
     *
     * @param object $response
     * @param AccessToken $token
     * @return mixed
     */
    public function userDetails($response, AccessToken $token)
    {
        return new TwitchUser((array)$response);
    }
}
