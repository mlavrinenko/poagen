<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeScanningAlertRuleSummary implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', null],
        'full_description' => ['full_description', null],
        'help' => ['help', null],
        'help_uri' => ['help_uri', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'security_severity_level' => ['security_severity_level', null],
        'severity' => ['severity', null],
        'tags' => ['tags', ['list', null]],
    ];

    /**
     * @param ?list<string> $tags
     */
    public function __construct(
        public ?string $description = null,
        public ?string $full_description = null,
        public ?string $help = null,
        public ?string $help_uri = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $security_severity_level = null,
        public ?string $severity = null,
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
            'full_description' => $this->full_description,
            'help' => $this->help,
            'help_uri' => $this->help_uri,
            'id' => $this->id,
            'name' => $this->name,
            'security_severity_level' => $this->security_severity_level,
            'severity' => $this->severity,
            'tags' => $this->tags,
        ];
    }
}
