<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PersonalAccessTokenRequestPermissions_result implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'organization' => ['organization', null],
        'other' => ['other', null],
        'repository' => ['repository', null],
    ];

    /**
     * @param ?array<string, string> $organization
     * @param ?array<string, string> $other
     * @param ?array<string, string> $repository
     */
    public function __construct(
        public ?array $organization = null,
        public ?array $other = null,
        public ?array $repository = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'organization' => $this->organization,
            'other' => $this->other,
            'repository' => $this->repository,
        ];
    }
}
