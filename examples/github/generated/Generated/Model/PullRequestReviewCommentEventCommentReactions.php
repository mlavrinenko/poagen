<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Mlavrinenko\Paogen\Runtime\Attribute\WireName;

final readonly class PullRequestReviewCommentEventCommentReactions
{
    public function __construct(
        #[WireName('-1')]
        public ?int $_1 = null,
        public ?int $confused = null,
        public ?int $eyes = null,
        public ?int $heart = null,
        public ?int $hooray = null,
        public ?int $laugh = null,
        public ?int $rocket = null,
        public ?int $total_count = null,
        public ?string $url = null,
    ) {
    }
}
