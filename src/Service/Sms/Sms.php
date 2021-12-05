<?php

namespace OrangeApiClient\Service\Sms;

use OrangeApiClient\Client;
use Symfony\Contracts\HttpClient\ResponseInterface;
use OrangeApiClient\Service\AbstractAuthenticatedService;


/**
 * The Orange SMS API Service
 * https://developer.orange.com/apis/sms/getting-started
 */
class Sms extends AbstractAuthenticatedService
{
    /**
     * Construct The Orange SMS API Service
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    /**
     * Send SMS Message
     * 
     * @param Message $message
     * @return ResponseInterface
     */
    public function doSend(Message $message): ResponseInterface
    {
        if (empty($message->getMessage())) {
            throw new \InvalidArgumentException("SMS message content can't be empty!", 1);
        }
        if (empty($message->getSenderAddress())) {
            throw new \InvalidArgumentException("SMS message senderAddress (from) can't be empty", 1);
        }
        if (empty($message->getAddress())) {
            throw new \InvalidArgumentException("SMS message address (to) can't be empty", 1);
        }

        $url = $this->client->getHost() . '/smsmessaging/v1/outbound/' . urlencode("tel:+{$message->getSenderAddress()}") . '/requests';
        $headers = [
            'Authorization' =>  'Bearer ' . $this->getAccessToken(),
            'Content-Type'  =>  'application/json'
        ];

        $args = [
            'outboundSMSMessageRequest' => [
                'address'                   =>  "tel:+{$message->getAddress()}",
                'senderAddress'             =>  "tel:+{$message->getSenderAddress()}",
                'outboundSMSTextMessage'    =>  [
                    'message'   =>  $message->getMessage(),
                ]
            ]
        ];
        
        if (!empty($message->getSenderName())) {
            $args['outboundSMSMessageRequest']['senderName'] = urlencode($message->getSenderName());
        }

        return  $this->client->getHttpClient()->request('POST', $url, [
            'headers'   => $headers,
            'json'      => $args
        ]);
    }

    /**
     * Get Contracts
     * 
     * @param array $argsOptions
     * @return ResponseInterface
     */
    public function getContracts(
            array $argsOptions = [
                'contry'   =>  '',
            ]
        ): ResponseInterface
    {
        $args = [];
        if (array_key_exists('contry', $argsOptions) && !empty($argsOptions['contry'])) {
            $args['contry'] = $argsOptions['contry'];
        }

        $url = $this->client->getHost() . '/sms/admin/v1/contracts';
        $headers = [
            'Authorization' =>  'Bearer ' . $this->getAccessToken(),
            'Content-Type'  =>  'application/json'
        ];

        return  $this->client->getHttpClient()->request('GET', $url, [
            'headers'   => $headers,
            'json'      => json_encode($args),
        ]);
    }

    /**
     * Get Statistics
     * 
     * @param array $argsOptions
     * @return ResponseInterface
     */
    public function getStatistics(
            array $argsOptions = [
                'contry'   =>  '',
                'appid'    =>  '',
            ]
        ): ResponseInterface
    {
        $args = [];
        if (array_key_exists('contry', $argsOptions) && !empty($argsOptions['contry'])) {
            $args['contry'] = $argsOptions['contry'];
        }
        if (array_key_exists('appid', $argsOptions) && !empty($argsOptions['appid'])) {
            $args['appid'] = $argsOptions['appid'];
        }

        $url = $this->client->getHost() . '/sms/admin/v1/statistics';
        $headers = [
            'Authorization' =>  'Bearer ' . $this->getAccessToken(),
            'Content-Type'  =>  'application/json'
        ];

        return  $this->client->getHttpClient()->request('GET', $url, [
            'headers'   => $headers,
            'json'      => json_encode($args),
        ]);
    }

    /**
     * Get Purchase Orders
     * 
     * @param array $argsOptions
     * @return ResponseInterface
     */
    public function getPurchaseOrders(
            array $argsOptions = [
                'contry'   =>  '',
            ]
        ): ResponseInterface
    {
        $args = [];
        if (array_key_exists('contry', $argsOptions) && !empty($argsOptions['contry'])) {
            $args['contry'] = $argsOptions['contry'];
        }

        $url = $this->client->getHost() . '/sms/admin/v1/purchaseorders';
        $headers = [
            'Authorization' =>  'Bearer ' . $this->getAccessToken(),
            'Content-Type'  =>  'application/json'
        ];

        return  $this->client->getHttpClient()->request('GET', $url, [
            'headers'   => $headers,
            'json'      => json_encode($args),
        ]);
    }

    /**
     * Verify delivery receipt subscription
     * 
     * @param int $devPhoneNumber
     * @param string $notifyUrl
     * @return ResponseInterface
     */
    public function deliveryReceiptSubscription(int $devPhoneNumber, string $notifyUrl): ResponseInterface
    {
        $url = $this->client->getHost() . '/smsmessaging/v1/outbound/' . urlencode("tel:+{$devPhoneNumber}") . '/subscriptions';
        $headers = [
            'Authorization' =>  'Bearer ' . $this->getAccessToken(),
            'Content-Type'  =>  'application/json'
        ];

        $args = [
            "deliveryReceiptSubscription"   =>  [
                "callbackReference" =>  [
                    "notifyURL" =>  $notifyUrl,
                ]
            ]
        ];

        return  $this->client->getHttpClient()->request('POST', $url, [
            'headers'   => $headers,
            'json'      => $args,
        ]);
    }

    /**
     * Unsubscript delivery receipt
     * 
     * @param int $devPhoneNumber
     * @param string $subscriptionId
     * @return ResponseInterface
     */
    public function deliveryReceiptUnsubscription(int $devPhoneNumber, string $subscriptionId): ResponseInterface
    {
        $url = $this->client->getHost() . '/smsmessaging/v1/outbound/' . urlencode("tel:+{$devPhoneNumber}") . '/subscriptions/' . $subscriptionId;
        $headers = [
            'Authorization' =>  'Bearer ' . $this->getAccessToken(),
            'Content-Type'  =>  'application/json'
        ];

        return  $this->client->getHttpClient()->request('DELETE', $url, [
            'headers'   => $headers,
        ]);
    }

    /**
     * Subscript delivery receipt
     * 
     * @param string $subscriptionId
     * @return ResponseInterface
     */
    public function deliveryReceiptSubscriptionVerification($subscriptionId): ResponseInterface
    {
        $url = $this->client->getHost() . '/smsmessaging/v1/outbound/subscriptions/' . $subscriptionId;
        $headers = [
            'Authorization' =>  'Bearer ' . $this->getAccessToken(),
            'Content-Type'  =>  'application/json'
        ];

        return  $this->client->getHttpClient()->request('GET', $url, [
            'headers'   => $headers,
        ]);
    }
}
