<?php
namespace OrangeApiClient\Services;

use OrangeApiClient\Authentication\TokenAuthentication;

abstract class AuthenticatedService implements AuthenticatedServiceInterface
{
    protected $auth;

    public function __construct(TokenAuthentication $auth)
    {
        $this->auth = $auth;
    }
    
    public function getAccessToken(): string
    {
        return $this->auth->getAccessToken();
    }
}
