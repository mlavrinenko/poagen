<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\Distribution;
use DateTimeImmutable;

final readonly class Image
{
    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?ImageDescription $description = null,
        public ?Distribution $distribution = null,
        public ?string $error_message = null,
        public ?int $id = null,
        public ?int $min_disk_size = null,
        public ?ImageName $name = null,
        public ?bool $public = null,
        public ?RegionsArray $regions = null,
        public ?float $size_gigabytes = null,
        public ?string $slug = null,
        public ?string $status = null,
        public ?TagsArray $tags = null,
        public ?string $type = null,
    ) {
    }
}
