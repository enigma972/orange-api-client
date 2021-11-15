<?php
require_once './../../vendor/autoload.php';

use OrangeApiClient\Service\Sms\Sms;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use OrangeApiClient\Client;

$cache = new FilesystemAdapter();
$client = new Client($cache, 'YOUR-CLIENT-ID', 'YOUR-CLIENT-SECRET');

$sms = new Sms($client);

$response = $sms->getContracts([
    'contry'   =>  'CONTRY-CODE',
]);

dd($response->toArray());