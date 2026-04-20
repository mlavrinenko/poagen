<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class NullableLicenseSimple
{
    public function __construct(
        public string $key,
        public string $name,
        public string $node_id,
        public ?string $spdx_id = null,
        public ?string $url = null,
        public ?string $html_url = null,
    ) {
    }
}
