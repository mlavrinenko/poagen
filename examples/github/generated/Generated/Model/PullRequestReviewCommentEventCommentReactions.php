<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PullRequestReviewCommentEventCommentReactions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_1' => ['-1', null],
        'confused' => ['confused', null],
        'eyes' => ['eyes', null],
        'heart' => ['heart', null],
        'hooray' => ['hooray', null],
        'laugh' => ['laugh', null],
        'rocket' => ['rocket', null],
        'total_count' => ['total_count', null],
        'url' => ['url', null],
    ];

    public function __construct(
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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            '+1' => $this->_1,
            '-1' => $this->_1,
            'confused' => $this->confused,
            'eyes' => $this->eyes,
            'heart' => $this->heart,
            'hooray' => $this->hooray,
            'laugh' => $this->laugh,
            'rocket' => $this->rocket,
            'total_count' => $this->total_count,
            'url' => $this->url,
        ];
    }
}
