<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class PageBuild implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'commit' => ['commit', null],
        'created_at' => ['created_at', ['datetime', null]],
        'duration' => ['duration', null],
        'error' => ['error', \Acme\GitHub\Generated\Model\PageBuildError::class],
        'pusher' => ['pusher', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'status' => ['status', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
    ];

    public function __construct(
        public string $commit,
        public DateTimeImmutable $created_at,
        public int $duration,
        public PageBuildError $error,
        public NullableSimpleUser $pusher,
        public string $status,
        public DateTimeImmutable $updated_at,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'commit' => $this->commit,
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'duration' => $this->duration,
            'error' => $this->error,
            'pusher' => $this->pusher,
            'status' => $this->status,
            'updated_at' => $this->updated_at->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
        ];
    }
}
