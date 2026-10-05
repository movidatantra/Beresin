<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BrickService
{
    protected $clientId;
    protected $clientSecret;
    protected $baseUrl;

    public function __construct()
    {
        $this->clientId = config('services.brick.client_id');
        $this->clientSecret = config('services.brick.client_secret');
        // Mendefinisikan baseUrl agar tidak undefined property error
        $this->baseUrl = 'https://sandbox.onebrick.io/v2';
    }

    public function getAccessToken()
{
    $response = Http::withBasicAuth(
        $this->clientId,
        $this->clientSecret
    )->get(
        "{$this->baseUrl}/payments/auth/token"
    );

    if (!$response->successful()) {
        return null;
    }

    return $response->json('data.accessToken');
}

    public function verifyAccount($bankShortCode, $accountNumber)
{
    $token = $this->getAccessToken();

    if (!$token) {
        return [
            'status' => 'error',
            'message' => 'Failed to retrieve access token.'
        ];
    }

    $response = Http::withHeaders([
        'publicAccessToken' => $token,
        'Accept' => 'application/json',
    ])->get(
        "{$this->baseUrl}/payments/gs/bank-account-validation",
        [
            'accountNumber' => $accountNumber,
            'bankShortCode' => $bankShortCode,
        ]
    );

    return $response->json();
}
}