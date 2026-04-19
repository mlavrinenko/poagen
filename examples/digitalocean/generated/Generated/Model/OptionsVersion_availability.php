<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class OptionsVersion_availability implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'kafka' => ['kafka', \Acme\DigitalOcean\Generated\Model\DatabaseVersionAvailabilities::class],
        'mongodb' => ['mongodb', \Acme\DigitalOcean\Generated\Model\DatabaseVersionAvailabilities::class],
        'mysql' => ['mysql', \Acme\DigitalOcean\Generated\Model\DatabaseVersionAvailabilities::class],
        'opensearch' => ['opensearch', \Acme\DigitalOcean\Generated\Model\DatabaseVersionAvailabilities::class],
        'pg' => ['pg', \Acme\DigitalOcean\Generated\Model\DatabaseVersionAvailabilities::class],
        'redis' => ['redis', \Acme\DigitalOcean\Generated\Model\DatabaseVersionAvailabilities::class],
        'valkey' => ['valkey', \Acme\DigitalOcean\Generated\Model\DatabaseVersionAvailabilities::class],
    ];

    public function __construct(
        public ?DatabaseVersionAvailabilities $kafka = null,
        public ?DatabaseVersionAvailabilities $mongodb = null,
        public ?DatabaseVersionAvailabilities $mysql = null,
        public ?DatabaseVersionAvailabilities $opensearch = null,
        public ?DatabaseVersionAvailabilities $pg = null,
        public ?DatabaseVersionAvailabilities $redis = null,
        public ?DatabaseVersionAvailabilities $valkey = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'kafka' => $this->kafka,
            'mongodb' => $this->mongodb,
            'mysql' => $this->mysql,
            'opensearch' => $this->opensearch,
            'pg' => $this->pg,
            'redis' => $this->redis,
            'valkey' => $this->valkey,
        ];
    }
}
