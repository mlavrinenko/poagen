<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class PagesHttpsCertificate
{
    /**
     * @param list<string> $domains
     */
    public function __construct(
        public string $description,
        public array $domains,
        public string $state,
        #[Format('date')]
        public ?DateTimeImmutable $expires_at = null,
    ) {
    }
}
