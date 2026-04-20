<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Contact\Generated\Model;

use Mlavrinenko\Paogen\Runtime\Attribute\WireName;
use Mlavrinenko\Paogen\Tests\Fixtures\ValueObject\Email;

final readonly class Contact
{
    public function __construct(
        #[WireName('display-name')]
        public string $displayName,
        public Email $email,
        public ?string $nickname = null,
        public ?int $org_id = null,
    ) {
    }
}
