<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class OptionsOptions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'kafka' => ['kafka', null],
        'mongodb' => ['mongodb', null],
        'mysql' => ['mysql', null],
        'opensearch' => ['opensearch', null],
        'pg' => ['pg', null],
        'redis' => ['redis', null],
        'valkey' => ['valkey', null],
    ];

    /**
     * @param ?mixed $kafka
     * @param ?mixed $mongodb
     * @param ?mixed $mysql
     * @param ?mixed $opensearch
     * @param ?mixed $pg
     * @param ?mixed $redis
     * @param ?mixed $valkey
     */
    public function __construct(
        public $kafka = null,
        public $mongodb = null,
        public $mysql = null,
        public $opensearch = null,
        public $pg = null,
        public $redis = null,
        public $valkey = null,
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
