<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleViolationError implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'documentation_url' => ['documentation_url', null],
        'message' => ['message', null],
        'metadata' => ['metadata', \Acme\GitHub\Generated\Model\RepositoryRuleViolationErrorMetadata::class],
        'status' => ['status', null],
    ];

    public function __construct(
        public ?string $documentation_url = null,
        public ?string $message = null,
        public ?RepositoryRuleViolationErrorMetadata $metadata = null,
        public ?string $status = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'documentation_url' => $this->documentation_url,
            'message' => $this->message,
            'metadata' => $this->metadata,
            'status' => $this->status,
        ];
    }
}
