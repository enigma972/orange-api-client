<?php

namespace OrangeApiClient\Services;


interface AuthenticatedServiceInterface
{
    public function getAccessToken();

    public function getEndpoint();
}