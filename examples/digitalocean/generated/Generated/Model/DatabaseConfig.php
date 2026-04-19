<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DatabaseConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'config' => [
            'config',
            [
                'union',
                [
                    \Acme\DigitalOcean\Generated\Model\MysqlAdvancedConfig::class,
                    \Acme\DigitalOcean\Generated\Model\PostgresAdvancedConfig::class,
                    \Acme\DigitalOcean\Generated\Model\RedisAdvancedConfig::class,
                    \Acme\DigitalOcean\Generated\Model\ValkeyAdvancedConfig::class,
                    \Acme\DigitalOcean\Generated\Model\MongoAdvancedConfig::class,
                    \Acme\DigitalOcean\Generated\Model\KafkaAdvancedConfig::class,
                    \Acme\DigitalOcean\Generated\Model\OpensearchAdvancedConfig::class,
                ],
                null,
            ],
        ],
    ];

    public function __construct(
        public MysqlAdvancedConfig|PostgresAdvancedConfig|RedisAdvancedConfig|ValkeyAdvancedConfig|MongoAdvancedConfig|KafkaAdvancedConfig|OpensearchAdvancedConfig|null $config = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'config' => $this->config,
        ];
    }
}
