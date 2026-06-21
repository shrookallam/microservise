<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use longlang\phpkafka\Consumer\Consumer;
use longlang\phpkafka\Consumer\ConsumerConfig;

class ConsumeProductCreated extends Command
{
    protected $signature   = 'kafka:consume-products';
    protected $description = 'Listen for product.created events and create orders';

    public function handle(): void
    {
        $config = new ConsumerConfig();
        $config->setBroker('kafka:9092');
        $config->setTopic('product.created');
        $config->setGroupId('order-service');
        $config->setAutoCommit(false);

        $consumer = new Consumer($config);

        $this->info('Listening on product.created...');

        while (true) {
            $message = $consumer->consume();

            if ($message === null) {
                continue;
            }

            $payload = json_decode($message->getValue(), true);

            Order::create([
                'product_id'   => $payload['id'],
                'quantity' =>1
            ]);

            $consumer->ack($message);
            $this->info("Order created for product: {$payload['name']}");
        }
    }
}
