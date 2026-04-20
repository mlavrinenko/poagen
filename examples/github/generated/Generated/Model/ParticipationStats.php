<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ParticipationStats
{
    /**
     * @param list<int> $all
     * @param list<int> $owner
     */
    public function __construct(
        public array $all,
        public array $owner,
    ) {
    }
}
