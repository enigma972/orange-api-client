<?php
require_once './../../vendor/autoload.php';

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use OrangeApiClient\Client;

$cache = new FilesystemAdapter();
$client = new Client($cache, 'YOUR-CLIENT-ID', 'YOUR-CLIENT-SECRET');

$token = $client->getAccessToken();

dd($token);