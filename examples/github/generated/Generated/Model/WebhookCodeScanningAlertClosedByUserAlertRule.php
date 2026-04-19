<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookCodeScanningAlertClosedByUserAlertRule implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'id' => ['id', null],
        'severity' => ['severity', null],
        'full_description' => ['full_description', null],
        'help' => ['help', null],
        'help_uri' => ['help_uri', null],
        'name' => ['name', null],
        'tags' => ['tags', ['list', null]],
    ];

    /**
     * @param ?list<string> $tags
     */
    public function __construct(
        public string $description,
        public string $id,
        public ?string $severity = null,
        public ?string $full_description = null,
        public ?string $help = null,
        public ?string $help_uri = null,
        public ?string $name = null,
        public ?array $tags = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'id' => $this->id,
            'severity' => $this->severity,
            'full_description' => $this->full_description,
            'help' => $this->help,
            'help_uri' => $this->help_uri,
            'name' => $this->name,
            'tags' => $this->tags,
        ];
    }
}
