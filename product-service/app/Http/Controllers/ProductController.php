<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\EventBus;
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
           EventBus::publish('product.created', [
        'product_id' => $product->id,
        'name' => $product->name,
        'price' => $product->price,
    ]);


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
