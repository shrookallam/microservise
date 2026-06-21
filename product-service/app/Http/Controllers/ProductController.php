<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\EventBus;
use App\Services\KafkaProducer;
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

app(KafkaProducer::class)->publish('product.created', [
            'id'    => $product->id,
            'name'  => $product->name,
            'price' => $product->price,
        ]);
        return response()->json($product);


}
}
