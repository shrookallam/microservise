<?php

namespace App\Services;

use longlang\phpkafka\Producer\Producer;
use longlang\phpkafka\Producer\ProducerConfig;

class KafkaProducer
{
    public function publish(string $topic, array $payload): void
    {
        $config = new ProducerConfig();
        $config->setBootstrapServers('kafka:9092');
        $config->setAcks(-1);

        $producer = new Producer($config);
        $producer->send($topic, json_encode($payload), uniqid());
        $producer->close();
    }
}
