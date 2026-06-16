<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class EventController extends Controller
{
    public function handle(Request $request)
    {
        $event = $request->event;
        $payload = $request->payload;

        if ($event === 'product.created') {

            Order::create([
                'product_id' => $payload['product_id'],
                'quantity' => 1,
            ]);
        }

        return response()->json([
            'message' => 'Event processed'
        ]);
    }
}
