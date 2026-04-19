<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookRepositoryRulesetEditedChangesRules implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'added' => ['added', ['list', \Acme\GitHub\Generated\Model\RepositoryRule::class]],
        'deleted' => ['deleted', ['list', \Acme\GitHub\Generated\Model\RepositoryRule::class]],
        'updated' => ['updated', ['list', null]],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryRule> $added
     * @param ?list<\Acme\GitHub\Generated\Model\RepositoryRule> $deleted
     * @param ?list<array<string, mixed>> $updated
     */
    public function __construct(
        public ?array $added = null,
        public ?array $deleted = null,
        public ?array $updated = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'added' => $this->added,
            'deleted' => $this->deleted,
            'updated' => $this->updated,
        ];
    }
}
