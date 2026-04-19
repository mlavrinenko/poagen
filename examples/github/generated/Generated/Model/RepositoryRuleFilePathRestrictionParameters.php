<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RepositoryRuleFilePathRestrictionParameters implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['restricted_file_paths' => ['restricted_file_paths', ['list', null]]];

    /**
     * @param list<string> $restricted_file_paths
     */
    public function __construct(
        public array $restricted_file_paths,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'restricted_file_paths' => $this->restricted_file_paths,
        ];
    }
}
