<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class KafkaSchemaVerbose
{
    public function __construct(
        public ?string $schema = null,
        public ?int $schema_id = null,
        public ?string $schema_type = null,
        public ?string $subject_name = null,
    ) {
    }
}
