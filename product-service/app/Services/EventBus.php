<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EventBus
{
    public static function publish(string $eventName, array $payload)
    {
        Http::post('http://order-service.test/api/events', [
            'event' => $eventName,
            'payload' => $payload
        ]);
    }
}
