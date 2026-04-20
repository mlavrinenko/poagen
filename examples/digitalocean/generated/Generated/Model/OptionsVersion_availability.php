<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class OptionsVersion_availability
{
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
}
