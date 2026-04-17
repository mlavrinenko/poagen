<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Contact\Generated\Model;

use Mlavrinenko\Paogen\Tests\Fixtures\ValueObject\Email;

final readonly class Contact
{
    public function __construct(
        public Email $email,
        public ?string $nickname = null,
    ) {
    }
}
