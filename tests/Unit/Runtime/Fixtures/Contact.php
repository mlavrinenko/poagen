<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit\Runtime\Fixtures;

final readonly class Contact
{
    public function __construct(
        #[\Poagen\Runtime\Attribute\WireName('display-name')]
        public string $displayName = '',
        public ?Email $email = null,
    ) {}
}
