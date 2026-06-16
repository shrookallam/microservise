<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Facades\Kafka;
use App\Models\Order;

class ConsumeProductCreated extends Command
{
    protected $signature = 'kafka:consume-products';

    public function handle()
    {
        Kafka::createConsumer()
            ->subscribe('product.created')
            ->withHandler(function ($message) {

                $data = $message->getBody();

                Order::create([
                    'product_id' => $data['product_id'],
                    'quantity' => 1,
                ]);

                $this->info('Order created for product: ' . $data['product_id']);
            })
            ->build()
            ->consume();
    }
}
