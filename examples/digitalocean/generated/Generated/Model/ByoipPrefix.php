<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ByoipPrefix implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'advertised' => ['advertised', null],
        'failure_reason' => ['failure_reason', null],
        'locked' => ['locked', null],
        'name' => ['name', null],
        'prefix' => ['prefix', null],
        'project_id' => ['project_id', null],
        'region' => ['region', null],
        'status' => ['status', null],
        'uuid' => ['uuid', null],
        'validations' => ['validations', ['list', null]],
    ];

    /**
     * @param ?list<array<string, mixed>> $validations
     */
    public function __construct(
        public ?bool $advertised = null,
        public ?string $failure_reason = null,
        public ?bool $locked = null,
        public ?string $name = null,
        public ?string $prefix = null,
        public ?string $project_id = null,
        public ?string $region = null,
        public ?string $status = null,
        public ?string $uuid = null,
        public ?array $validations = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'advertised' => $this->advertised,
            'failure_reason' => $this->failure_reason,
            'locked' => $this->locked,
            'name' => $this->name,
            'prefix' => $this->prefix,
            'project_id' => $this->project_id,
            'region' => $this->region,
            'status' => $this->status,
            'uuid' => $this->uuid,
            'validations' => $this->validations,
        ];
    }
}
