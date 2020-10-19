<?php

namespace Depotwarehouse\OAuth2\Client\Twitch\Provider;

use Depotwarehouse\OAuth2\Client\Twitch\Entity\TwitchUser;
use League\OAuth2\Client\Provider\AbstractProvider;
use Depotwarehouse\OAuth2\Client\Twitch\Provider\Exception\TwitchIdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Twitch extends AbstractProvider
{

    /**
     * The domain for authorization.
     *
     * @var string
     */
    public $authorizationDomain = 'https://id.twitch.tv';

    /**
     * The path for authorization.
     *
     * @var string
     */
    public $authorizationPath = '/oauth2';

    /**
     * The domain with resources.
     *
     * @var string
     */
    public $resourceDomain = 'https://api.twitch.tv';

    /**
     * The path with resources.
     *
     * @var string
     */
    public $resourcePath = '/helix';

    public $scopes = [ 'user_read' ];

    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->authorizationDomain.$this->authorizationPath.'/authorize';
    }

    /**
     * Get access token url to retrieve token
     *
     * @param  array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->authorizationDomain.$this->authorizationPath.'/token';
    }

    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->resourceDomain.$this->resourcePath.'/users?oauth_token='.$token->getToken();
    }

    /**
     * Get the full uri with appended oauth_token query string
     *
     * @param string $endpoint | with leading slash
     * @param AccessToken $token
     * @return string
     */
    public function getAuthenticatedUrlForEndpoint($endpoint, AccessToken $token)
    {
        return $this->authorizationDomain.$endpoint.'?oauth_token='.$token->getToken();
    }

    /**
     * Get the full urls that do not require authentication
     *
     * @param $endpoint
     * @return string
     */
    public function getUrlForEndpoint($endpoint)
    {
        return $this->authorizationDomain.$endpoint;
    }

    /**
     * Returns the string that should be used to separate scopes when building
     * the URL for requesting an access token.
     *
     * @return string Scope separator
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return $this->scopes;
    }

    /**
     * Checks response
     *
     * @param ResponseInterface $response
     * @param array|string $data
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400)
        {
            throw TwitchIdentityProviderException::clientException($response, $data);
        }
        elseif (isset($data['error']))
        {
            throw TwitchIdentityProviderException::oauthException($response, $data);
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return TwitchUser
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new TwitchUser((array)$response);
    }

    /**
     * Since August 8th, 2016 Kraken requires a Client-ID header to be sent
     *
     * @return array
     */
    protected function getDefaultHeaders()
    {
        return ['Client-ID' => $this->clientId];
    }

    /**
     * Adds token to headers
     *
     * @param AccessToken $token
     * @return array
     */
    protected function getAuthorizationHeaders($token = null) {
      return $token ? [
        'Authorization' => 'Bearer ' . $token->getToken(),
      ] : [];
    }


}
