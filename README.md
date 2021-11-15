# Orange API Client (SDK)
Orange APIs Client with Token Caching

## Installation

You need to have composer installed in your computer before doing this

```bash
composer require enigma972/orange-api-client
```

## Quick setup and Basic example (SMS)

Get `client_id` and `client_secret` [here](https://developer.orange.com/myapps/)

All examples [here](https://github.com/enigma972/orange-api-client/tree/main/examples/Sms)

```php
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
    ->as('Enigma972')
    ->to(243899999999)
    ;

$response = $sms->doSend($message);

dd($response->toArray());

```
If all is ok, $response should be like this :

```
^ array:1 [▼
  "outboundSMSMessageRequest" => array:4 [▼
    "address" => array:1 [▼
      0 => "tel:+243899999999"
    ]
    "senderAddress" => "tel:+243899999999"
    "outboundSMSTextMessage" => array:1 [▼
      "message" => "Hello world, via Orange SMS API."
    ]
    "resourceURL" => "https://api.orange.com/smsmessaging/v1/outbound/tel:+243899999999/requests/2fdd2d6e-c155-43d3-97ef-1dce0dc648d5"
  ]
]
```

Also read [here](https://github.com/ismaeltoe/osms) and [here](https://github.com/informagenie/orange-sms).