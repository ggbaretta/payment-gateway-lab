<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WebhookSenderService {
    public function send(string $url, array $payload) {
        $secret = config('app.webhook_secret', 'secret-chave-123');
        
        $signature = hash_hmac('sha256', json_encode($payload), $secret);

        return Http::withHeaders([
            'X-Gateway-Signature' => $signature,
            'Content-Type' => 'application/json'
        ])->post($url, $payload);
    }
}