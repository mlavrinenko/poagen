<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ProjectsV2SingleSelectOptions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'color' => ['color', null],
        'description' => ['description', \Acme\GitHub\Generated\Model\ProjectsV2SingleSelectOptionsDescription::class],
        'id' => ['id', null],
        'name' => ['name', \Acme\GitHub\Generated\Model\ProjectsV2SingleSelectOptionsName::class],
    ];

    public function __construct(
        public string $color,
        public ProjectsV2SingleSelectOptionsDescription $description,
        public string $id,
        public ProjectsV2SingleSelectOptionsName $name,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'color' => $this->color,
            'description' => $this->description,
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
