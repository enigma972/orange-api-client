<?php

namespace OrangeApiClient\Authentication;

use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\CacheInterface;

class TokenAuthentication
{
    public const HOST = 'https://api.orange.com';
	// Token life time (in seconds): 49 min 45 sec
	public const TOKEN_LIFE_TIME = 3585;

    protected $key;
    protected $cache;
    private $accessToken = [
      'token'           =>    '',
      'expirationTime'  =>    '',
   ];

    public function __construct(string $key, CacheInterface $cache)
    {
        $this->key = $key;
        $this->cache = $cache;

		$this->setAccessTokenFromCache($cache);
    }

    public function getAccessToken(): string
    {
        if (!$this->hasValidToken($this->accessToken)) {
			// Get Access Token
            $token = $this->makeTokenRequest($this->key);

			$this->accessToken['token'] = $token;
        	$this->accessToken['expirationTime'] = time() + self::TOKEN_LIFE_TIME;

        	$this->cache->set('orange-api-client-access-token', $this->accessToken);
        }

        return $this->accessToken['token'];
    }

	protected function setAccessTokenFromCache($cache): void
	{
		if (null == $accessToken = $cache->get('orange-api-client-access-token')) {
			return;
		}

		$this->accessToken['token'] = $accessToken['token'];
        $this->accessToken['expirationTime'] = $accessToken['expirationTime'];
	}

	/**
	 * @param string $key
	 * 
	 * @throws ClientException Get Access Token Failled
	 * 
	 * @return string
	 */
    public function makeTokenRequest(string $key): string
    {
        $client = HttpClient::create();

        $response = $client->request('POST', $this->getEndpoint(), [
            'headers'   =>  [
				'Authorization' =>  'Basic ' . $key,
				'Content-Type'  =>  'application/x-www-form-urlencoded',
				'Accept'        =>  'application/json'
			],
            'body'      =>  ['grant_type' => 'client_credentials'],
          ]);

        if (200 !== $response->getStatusCode()) {
            throw new ClientException($response);
        }
        
		return $response->toArray()['access_token'];
    }

    public function hasValidToken(array $accessToken): bool
    {
        return (array_key_exists('token', $accessToken) && !empty($accessToken['token']) && $accessToken['expirationTime'] > time()) ? true : false;
    }

    public function getEndpoint(): string
    {
        return self::HOST . '/oauth/v3/token';
    }
}
