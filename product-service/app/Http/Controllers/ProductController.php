<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
 public function store(Request $request)
{
    $product = Product::create([
        'name' => $request->name,
        'price' => $request->price,
    ]);

    try {
        $response = Http::withHeaders([
            'Authorization' => $request->header('Authorization')
        ])->post('http://order-service.test/api/orders', [
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        if (!$response->successful()) {
            throw new \Exception('Order Service failed');
        }

        return response()->json($product);

    } catch (\Exception $e) {

        $product->delete();

        return response()->json([
            'message' => 'Failed to create order, product rolled back',
            'error' => $e->getMessage()
        ], 500);
    }
}
}
