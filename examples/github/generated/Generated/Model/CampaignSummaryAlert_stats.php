<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CampaignSummaryAlert_stats implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'closed_count' => ['closed_count', null],
        'in_progress_count' => ['in_progress_count', null],
        'open_count' => ['open_count', null],
    ];

    public function __construct(
        public int $closed_count,
        public int $in_progress_count,
        public int $open_count,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'closed_count' => $this->closed_count,
            'in_progress_count' => $this->in_progress_count,
            'open_count' => $this->open_count,
        ];
    }
}
