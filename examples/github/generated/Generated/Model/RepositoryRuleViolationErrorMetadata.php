<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleViolationErrorMetadata implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'secret_scanning' => [
            'secret_scanning',
            \Acme\GitHub\Generated\Model\RepositoryRuleViolationErrorMetadataSecret_scanning::class,
        ],
    ];

    public function __construct(
        public ?RepositoryRuleViolationErrorMetadataSecret_scanning $secret_scanning = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'secret_scanning' => $this->secret_scanning,
        ];
    }
}
