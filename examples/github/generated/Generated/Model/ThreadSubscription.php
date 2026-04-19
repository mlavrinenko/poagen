<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ThreadSubscription implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'ignored' => ['ignored', null],
        'reason' => ['reason', null],
        'subscribed' => ['subscribed', null],
        'url' => ['url', null],
        'repository_url' => ['repository_url', null],
        'thread_url' => ['thread_url', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public bool $ignored,
        public ?string $reason = null,
        public bool $subscribed,
        public string $url,
        public ?string $repository_url = null,
        public ?string $thread_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'ignored' => $this->ignored,
            'reason' => $this->reason,
            'subscribed' => $this->subscribed,
            'url' => $this->url,
            'repository_url' => $this->repository_url,
            'thread_url' => $this->thread_url,
        ];
    }
}
