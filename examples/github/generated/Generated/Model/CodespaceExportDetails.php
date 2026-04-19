<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CodespaceExportDetails implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'branch' => ['branch', null],
        'completed_at' => ['completed_at', ['datetime', null]],
        'export_url' => ['export_url', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'sha' => ['sha', null],
        'state' => ['state', null],
    ];

    public function __construct(
        public ?string $branch = null,
        public ?DateTimeImmutable $completed_at = null,
        public ?string $export_url = null,
        public ?string $html_url = null,
        public ?string $id = null,
        public ?string $sha = null,
        public ?string $state = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'branch' => $this->branch,
            'completed_at' => $this->completed_at?->format(\DateTimeInterface::RFC3339),
            'export_url' => $this->export_url,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'sha' => $this->sha,
            'state' => $this->state,
        ];
    }
}
