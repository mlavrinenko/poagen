<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class KafkaSchemaVersionVerbose implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'schema' => ['schema', null],
        'schema_id' => ['schema_id', null],
        'schema_type' => ['schema_type', null],
        'subject_name' => ['subject_name', null],
        'version' => ['version', null],
    ];

    public function __construct(
        public ?string $schema = null,
        public ?int $schema_id = null,
        public ?string $schema_type = null,
        public ?string $subject_name = null,
        public ?string $version = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'schema' => $this->schema,
            'schema_id' => $this->schema_id,
            'schema_type' => $this->schema_type,
            'subject_name' => $this->subject_name,
            'version' => $this->version,
        ];
    }
}
