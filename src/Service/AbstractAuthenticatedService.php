<?php
namespace OrangeApiClient\Service;

use OrangeApiClient\Client;


/**
 * An abstract class extended  objects (services) that can fetch access token
 */
abstract class AbstractAuthenticatedService extends AbstractService implements AuthenticatedServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAccessToken(): string
    {
        return $this->client->getAccessToken();
    }
}
