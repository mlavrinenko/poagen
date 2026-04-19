<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeSecurityConfigurationRepositories implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'repository' => ['repository', \Acme\GitHub\Generated\Model\SimpleRepository::class],
        'status' => ['status', null],
    ];

    public function __construct(
        public ?SimpleRepository $repository = null,
        public ?string $status = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'repository' => $this->repository,
            'status' => $this->status,
        ];
    }
}
