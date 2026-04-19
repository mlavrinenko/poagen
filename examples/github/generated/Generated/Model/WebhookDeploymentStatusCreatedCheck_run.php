<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhookDeploymentStatusCreatedCheck_run implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'completed_at' => ['completed_at', ['datetime', null]],
        'conclusion' => ['conclusion', null],
        'details_url' => ['details_url', null],
        'external_id' => ['external_id', null],
        'head_sha' => ['head_sha', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'node_id' => ['node_id', null],
        'started_at' => ['started_at', ['datetime', null]],
        'status' => ['status', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public ?DateTimeImmutable $completed_at = null,
        public ?string $conclusion = null,
        public string $details_url,
        public string $external_id,
        public string $head_sha,
        public string $html_url,
        public int $id,
        public string $name,
        public string $node_id,
        public DateTimeImmutable $started_at,
        public string $status,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'completed_at' => $this->completed_at?->format(\DateTimeInterface::RFC3339),
            'conclusion' => $this->conclusion,
            'details_url' => $this->details_url,
            'external_id' => $this->external_id,
            'head_sha' => $this->head_sha,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'node_id' => $this->node_id,
            'started_at' => $this->started_at->format(\DateTimeInterface::RFC3339),
            'status' => $this->status,
            'url' => $this->url,
        ];
    }
}
