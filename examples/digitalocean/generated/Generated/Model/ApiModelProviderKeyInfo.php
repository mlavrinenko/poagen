<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiModelProvider;
use DateTimeImmutable;

final readonly class ApiModelProviderKeyInfo
{
    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiModel> $models
     */
    public function __construct(
        public ?string $api_key_uuid = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $created_by = null,
        public ?DateTimeImmutable $deleted_at = null,
        public ?array $models = null,
        public ?string $name = null,
        public ?ApiModelProvider $provider = null,
        public ?DateTimeImmutable $updated_at = null,
    ) {
    }
}
