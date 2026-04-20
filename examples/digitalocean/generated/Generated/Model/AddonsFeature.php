<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;

final readonly class AddonsFeature
{
    /**
     * @param mixed $value
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public int $id,
        public string $name,
        public string $type,
        public DateTimeImmutable $updated_at,
        public $value,
        public ?string $unit = null,
    ) {
    }
}
