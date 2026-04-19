<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class PagesHttpsCertificate implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'domains' => ['domains', ['list', null]],
        'state' => ['state', null],
        'expires_at' => ['expires_at', ['date', null]],
    ];

    /**
     * @param list<string> $domains
     */
    public function __construct(
        public string $description,
        public array $domains,
        public string $state,
        public ?DateTimeImmutable $expires_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'domains' => $this->domains,
            'state' => $this->state,
            'expires_at' => $this->expires_at?->format('Y-m-d'),
        ];
    }
}
