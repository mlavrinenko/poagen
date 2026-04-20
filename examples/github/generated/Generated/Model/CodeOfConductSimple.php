<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CodeOfConductSimple
{
    public function __construct(
        public ?string $html_url = null,
        public string $key,
        public string $name,
        public string $url,
    ) {
    }
}
