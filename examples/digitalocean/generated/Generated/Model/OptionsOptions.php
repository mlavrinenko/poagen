<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class OptionsOptions
{
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
}
