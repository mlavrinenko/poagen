<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CommunityProfile implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'documentation' => ['documentation', null],
        'files' => ['files', \Acme\GitHub\Generated\Model\CommunityProfileFiles::class],
        'health_percentage' => ['health_percentage', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'content_reports_enabled' => ['content_reports_enabled', null],
    ];

    public function __construct(
        public ?string $description = null,
        public ?string $documentation = null,
        public CommunityProfileFiles $files,
        public int $health_percentage,
        public ?DateTimeImmutable $updated_at = null,
        public ?bool $content_reports_enabled = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'documentation' => $this->documentation,
            'files' => $this->files,
            'health_percentage' => $this->health_percentage,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'content_reports_enabled' => $this->content_reports_enabled,
        ];
    }
}
