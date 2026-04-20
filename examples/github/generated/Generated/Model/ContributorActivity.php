<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ContributorActivity
{
    /**
     * @param list<array<string, mixed>> $weeks
     */
    public function __construct(
        public NullableSimpleUser $author,
        public int $total,
        public array $weeks,
    ) {
    }
}
