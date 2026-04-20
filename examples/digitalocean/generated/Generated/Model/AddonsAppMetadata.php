<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class AddonsAppMetadata
{
    /**
     * @param ?list<string> $options
     */
    public function __construct(
        public string $description,
        public string $display_name,
        public int $id,
        public string $name,
        public string $type,
        public ?array $options = null,
    ) {
    }
}
