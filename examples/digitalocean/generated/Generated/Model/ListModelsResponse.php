<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class ListModelsResponse
{
    /**
     * @param list<\Acme\DigitalOcean\Generated\Model\Model> $data
     */
    public function __construct(
        public array $data,
        public string $object,
    ) {
    }
}
