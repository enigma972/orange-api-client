<?php

namespace OrangeApiClient;

use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use OrangeApiClient\Authentication\TokenAuthentication;

/**
 * The Orange API Client
 * https://github.com/enigma972/orange-api-client
 */
class Client
{
    /**
     * @var string $host The Orange API URL
     */
    public $host;

    /**
     * @var CacheInterface $cache
     */
    protected $cache;

    /**
     * @var HttpClientInterface $httpClient
     */
    protected $httpClient;

    /**
     * @var string $clientId The client Identifier
     */
    protected $clientId;

    /**
     * @var string $clientSecret The client secret
     */
    protected $clientSecret;

    /**
     * Construct the Orange Cient
     * 
     * @param CaccheInerface $cache
     * @param string $clientId
     * @param string $clientSecret
     * @param string $host
     */
    public function __construct(CacheInterface $cache, string $clientId = '', string $clientSecret = '', string $host = 'https://api.orange.com')
    {
        $this->cache = $cache;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->host = $host;
        $this->httpClient = HttpClient::create();
    }

    /**
     * Retrieve Access Token from cache or request a new Access Token
     * 
     * @return string access token
     */
    public function getAccessToken(): string
    {
        return $this->cache->get('orange-api-client-access-token', function(ItemInterface $item) {
            $tokenAuthentication = new TokenAuthentication($this->host);
            $token = $tokenAuthentication->makeTokenRequest($this->httpClient, $this->getAuthorizationHeader());
            $item->expiresAfter(TokenAuthentication::TOKEN_LIFE_TIME);

            return $token;
        });
    }

    /**
     * @return string Authorization Header
     */
    public function getAuthorizationHeader(): string
    {
        return base64_encode($this->clientId . ':' . $this->clientSecret);
    }

    /**
     * @return string|null
     */
    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /**
     * @var string $clientId
     * @return self
     */
    public function setClientId(string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getClientSecret(): ?string
    {
        return $this->clientSecret;
    }

    /**
     * @var string $clientSecret
     * @return self
     */
    public function setClientSecret(string $clientSecret): self
    {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @var string $host
     * @return self
     */
    public function setHost(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return HttpClientInterface
     */
    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }
}
