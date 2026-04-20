<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class GeneratedImage
{
    public function __construct(
        public string $b64_json,
        public ?string $revised_prompt = null,
    ) {
    }
}
