<?php

declare(strict_types=1);

namespace Poagen\Generator\Tests\Unit\Runtime\Fixtures;

use Poagen\Runtime\Attribute\WireName;

final readonly class Contact
{
    public function __construct(
        #[WireName('display-name')]
        public string $displayName = '',
        public ?Email $email = null,
    ) {}
}
