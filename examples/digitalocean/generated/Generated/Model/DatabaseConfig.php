<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class DatabaseConfig
{
    public function __construct(
        public MysqlAdvancedConfig|PostgresAdvancedConfig|RedisAdvancedConfig|ValkeyAdvancedConfig|MongoAdvancedConfig|KafkaAdvancedConfig|OpensearchAdvancedConfig|null $config = null,
    ) {
    }
}
