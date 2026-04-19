<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookCodeScanningAlertAppearedInBranchAlertRule implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'id' => ['id', null],
        'severity' => ['severity', null],
    ];

    public function __construct(
        public string $description,
        public string $id,
        public ?string $severity = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'id' => $this->id,
            'severity' => $this->severity,
        ];
    }
}
