<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class CreateResponseStreamResponse
{
    /**
     * @param list<array<string, mixed>> $choices
     * @param ?mixed $usage
     */
    public function __construct(
        public array $choices,
        public int $created,
        public string $id,
        public string $model,
        public string $object,
        public $usage = null,
    ) {
    }
}
