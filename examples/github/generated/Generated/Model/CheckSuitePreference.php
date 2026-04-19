<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CheckSuitePreference implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'preferences' => ['preferences', \Acme\GitHub\Generated\Model\CheckSuitePreferencePreferences::class],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\MinimalRepository::class],
    ];

    public function __construct(
        public CheckSuitePreferencePreferences $preferences,
        public MinimalRepository $repository,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'preferences' => $this->preferences,
            'repository' => $this->repository,
        ];
    }
}
