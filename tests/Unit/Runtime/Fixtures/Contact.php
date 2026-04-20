<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Unit\Runtime\Fixtures;

use Mlavrinenko\Paogen\Runtime\Attribute\WireName;

final readonly class Contact
{
    public function __construct(
        #[WireName('display-name')]
        public string $displayName = '',
        public ?Email $email = null,
    ) {}
}
