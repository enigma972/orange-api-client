<?php

namespace OrangeApiClient\Service;

/**
 * An interface implemented by objects (services) that can fetch access token
 */
interface AuthenticatedServiceInterface
{
    /**
     * @return string Access Token
     */
    public function getAccessToken(): string;
}
