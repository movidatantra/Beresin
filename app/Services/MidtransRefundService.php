<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MidtransRefundService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([

            'base_uri' => config('midtrans.is_production')
                ? 'https://api.midtrans.com'
                : 'https://api.sandbox.midtrans.com',

            'timeout' => 30,

        ]);
    }

    public function refund($orderCode, $amount, $reason)
    {
        try {

            $response = $this->client->post(

                "/v2/{$orderCode}/refund",

                [

                    'auth' => [

                        config('midtrans.server_key'),

                        ''

                    ],

                    'headers' => [

                        'Accept' => 'application/json',

                        'Content-Type' => 'application/json'

                    ],

                    'json' => [

                        'refund_key' => 'RFD-'.time(),

                        'amount' => (int) $amount,

                        'reason' => $reason

                    ]

                ]

            );

            return json_decode(
                $response->getBody()->getContents(),
                true
            );

        }

        catch (RequestException $e) {

            if ($e->hasResponse()) {

                return json_decode(
                    $e->getResponse()->getBody()->getContents(),
                    true
                );

            }

            return [

                'status_code' => '500',

                'status_message' => $e->getMessage()

            ];

        }

        catch (\Exception $e) {

            return [

                'status_code' => '500',

                'status_message' => $e->getMessage()

            ];

        }

    }
}