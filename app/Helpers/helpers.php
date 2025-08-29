<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('send_debug_webhook')) {
    function send_debug_webhook(string $message): void
    {
        Http::post(config('app.webhook_url'), [
            'content' => $message
        ]);
    }
}
