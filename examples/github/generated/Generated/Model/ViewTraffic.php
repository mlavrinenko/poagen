<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ViewTraffic
{
    /**
     * @param list<\Acme\GitHub\Generated\Model\Traffic> $views
     */
    public function __construct(
        public int $count,
        public int $uniques,
        public array $views,
    ) {
    }
}
