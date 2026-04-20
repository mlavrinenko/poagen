<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\Distribution;
use Acme\DigitalOcean\Generated\Enum\RegionSlug;

final readonly class ImageNewCustom
{
    public function __construct(
        public ?ImageDescription $description = null,
        public ?Distribution $distribution = null,
        public ?ImageName $name = null,
        public ?RegionSlug $region = null,
        public ?TagsArray $tags = null,
        public ?string $url = null,
    ) {
    }
}
