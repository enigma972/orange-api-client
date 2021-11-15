<?php
require_once './../../vendor/autoload.php';

use OrangeApiClient\Service\Sms\Sms;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use OrangeApiClient\Client;
use OrangeApiClient\Service\Sms\Message;

$cache = new FilesystemAdapter();
$client = new Client($cache, 'YOUR-CLIENT-ID', 'YOUR-CLIENT-SECRET');

$sms = new Sms($client);

$message = new Message();
$message
    ->content('Hello world, via Orange SMS API.')
    ->from(243899999999)
    // ->as('Lussi')
    ->to(243899999999)
    ;

$response = $sms->doSend($message);

dd($response->toArray());