<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class RepositorySubscription implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'ignored' => ['ignored', null],
        'reason' => ['reason', null],
        'repository_url' => ['repository_url', null],
        'subscribed' => ['subscribed', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public DateTimeImmutable $created_at,
        public bool $ignored,
        public ?string $reason = null,
        public string $repository_url,
        public bool $subscribed,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'ignored' => $this->ignored,
            'reason' => $this->reason,
            'repository_url' => $this->repository_url,
            'subscribed' => $this->subscribed,
            'url' => $this->url,
        ];
    }
}
