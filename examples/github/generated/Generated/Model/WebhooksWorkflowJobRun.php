<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksWorkflowJobRun implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'conclusion' => ['conclusion', null],
        'created_at' => ['created_at', null],
        'environment' => ['environment', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'status' => ['status', null],
        'updated_at' => ['updated_at', null],
    ];

    /**
     * @param ?mixed $conclusion
     * @param ?mixed $name
     */
    public function __construct(
        public $conclusion = null,
        public string $created_at,
        public string $environment,
        public string $html_url,
        public int $id,
        public $name = null,
        public string $status,
        public string $updated_at,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'conclusion' => $this->conclusion,
            'created_at' => $this->created_at,
            'environment' => $this->environment,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
        ];
    }
}
