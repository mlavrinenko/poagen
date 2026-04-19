<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ImmutableReleasesOrganizationSettings implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'enforced_repositories' => ['enforced_repositories', null],
        'selected_repositories_url' => ['selected_repositories_url', null],
    ];

    public function __construct(
        public string $enforced_repositories,
        public ?string $selected_repositories_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'enforced_repositories' => $this->enforced_repositories,
            'selected_repositories_url' => $this->selected_repositories_url,
        ];
    }
}
