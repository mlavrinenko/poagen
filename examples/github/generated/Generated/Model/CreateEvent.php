<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CreateEvent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'full_ref' => ['full_ref', null],
        'master_branch' => ['master_branch', null],
        'pusher_type' => ['pusher_type', null],
        'ref' => ['ref', null],
        'ref_type' => ['ref_type', null],
        'description' => ['description', null],
    ];

    public function __construct(
        public string $full_ref,
        public string $master_branch,
        public string $pusher_type,
        public string $ref,
        public string $ref_type,
        public ?string $description = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'full_ref' => $this->full_ref,
            'master_branch' => $this->master_branch,
            'pusher_type' => $this->pusher_type,
            'ref' => $this->ref,
            'ref_type' => $this->ref_type,
            'description' => $this->description,
        ];
    }
}
