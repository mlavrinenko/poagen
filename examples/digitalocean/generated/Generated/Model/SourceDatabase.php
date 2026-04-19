<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class SourceDatabase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'source' => ['source', \Acme\DigitalOcean\Generated\Model\SourceDatabaseSource::class],
        'disable_ssl' => ['disable_ssl', null],
        'ignore_dbs' => ['ignore_dbs', ['list', null]],
    ];

    /**
     * @param ?list<string> $ignore_dbs
     */
    public function __construct(
        public SourceDatabaseSource $source,
        public ?bool $disable_ssl = null,
        public ?array $ignore_dbs = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'source' => $this->source,
            'disable_ssl' => $this->disable_ssl,
            'ignore_dbs' => $this->ignore_dbs,
        ];
    }
}
