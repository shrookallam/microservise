<?php

namespace App\Events;

class ProductCreatedEvent
{
    public function __construct(
        public int $productId,
        public string $name,
        public float $price
    ) {}
}
