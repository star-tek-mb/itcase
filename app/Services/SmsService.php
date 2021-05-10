<?php

namespace App\Services;

use GuzzleHttp\Client;
use Str;

class SmsService
{
    public function send($phone, $message)
    {
        $client = new Client([
            'base_uri' => config('services.sms.url'),
            'verify'   => false
        ]);
        $body = [
            'messages' => [
                [
                    'recipient' => $phone,
                    'message-id' => Str::random(20),
                    'sms' => [
                        'originator' => 'ITCASE',
                        'content' => [
                            'text' => $message
                        ]
                    ]
                ]
            ]
        ];
        $response = $client->post('', [
                'auth' => [config('services.sms.login'), config('services.sms.password')],
                'json' => $body
        ]);
        return json_decode($response->getBody(), true);
    }
}
