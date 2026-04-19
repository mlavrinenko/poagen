<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ActionsHostedRunnerCustomImageVersion implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_on' => ['created_on', null],
        'size_gb' => ['size_gb', null],
        'state' => ['state', null],
        'state_details' => ['state_details', null],
        'version' => ['version', null],
    ];

    public function __construct(
        public string $created_on,
        public int $size_gb,
        public string $state,
        public string $state_details,
        public string $version,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_on' => $this->created_on,
            'size_gb' => $this->size_gb,
            'state' => $this->state,
            'state_details' => $this->state_details,
            'version' => $this->version,
        ];
    }
}
