<?php

namespace OrangeApiClient\Service;

use OrangeApiClient\Client;


/**
 * An abstract class extended by all services
 */
abstract class AbstractService
{
    /**
     * @var Client The Orange API Client
     */
    protected $client;

    /**
     * Construct The Orange Service
     * 
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
