<?php

namespace App\Services;

use GuzzleHttp\Client;
use Str;

class SmsService
{

    private function isProblemOperators($phone)
    {
        // MTS, Yota, Megafon
        if (preg_match("/\\+7(901|902|904|908|910|911|912|913|914|915|916|917|918|919|950|978|980|981|982|983|984|985|986|987|988|989)/", $phone) ||
            preg_match("/\\+7(902|904|908|920|921|922|923|924|925|926|927|928|929|930|931|932|933|934|936|937|938|939|950|951|999)/", $phone))
        {
            return true;
        }
        return false;
    }

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
                        'originator' => $this->isProblemOperators($phone) ? 'DOSTAVKA' : 'ITCASE',
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
