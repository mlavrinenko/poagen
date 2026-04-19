<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class GistHistory implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'change_status' => ['change_status', \Acme\GitHub\Generated\Model\GistHistoryChange_status::class],
        'committed_at' => ['committed_at', ['datetime', null]],
        'url' => ['url', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'version' => ['version', null],
    ];

    public function __construct(
        public ?GistHistoryChange_status $change_status = null,
        public ?DateTimeImmutable $committed_at = null,
        public ?string $url = null,
        public ?NullableSimpleUser $user = null,
        public ?string $version = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'change_status' => $this->change_status,
            'committed_at' => $this->committed_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
            'user' => $this->user,
            'version' => $this->version,
        ];
    }
}
