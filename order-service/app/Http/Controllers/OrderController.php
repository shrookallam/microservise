<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
  public function store(Request $request)
{
   $order = Order::create([
    'product_id' => $request->product_id,
    'quantity' => $request->quantity,
]);

return response()->json($order);
}
}
