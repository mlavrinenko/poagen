<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class StatusMessages implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['message' => ['message', null], 'timestamp' => ['timestamp', ['datetime', null]]];

    public function __construct(
        public ?string $message = null,
        public ?DateTimeImmutable $timestamp = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'message' => $this->message,
            'timestamp' => $this->timestamp?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
