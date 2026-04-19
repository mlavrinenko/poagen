<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class DependabotAlertDismissalRequestSimple implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'id' => ['id', null],
        'requester' => ['requester', \Acme\GitHub\Generated\Model\DependabotAlertDismissalRequestSimpleRequester::class],
        'status' => ['status', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $created_at = null,
        public ?int $id = null,
        public ?DependabotAlertDismissalRequestSimpleRequester $requester = null,
        public ?string $status = null,
        public ?string $url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'id' => $this->id,
            'requester' => $this->requester,
            'status' => $this->status,
            'url' => $this->url,
        ];
    }
}
