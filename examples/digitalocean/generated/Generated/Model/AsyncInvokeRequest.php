<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AsyncInvokeRequest
{
    /**
     * @param ?list<array<string, mixed>> $tags
     */
    public function __construct(
        public AsyncInvokeRequestInput $input,
        public string $model_id,
        public ?array $tags = null,
    ) {
    }
}
