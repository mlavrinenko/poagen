<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class CloneTraffic
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\Traffic> $clones
     */
    public function __construct(
        public array $clones,
        public int $count,
        public int $uniques,
    ) {
    }
}
