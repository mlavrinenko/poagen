<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class MongoAdvancedConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'default_read_concern' => ['default_read_concern', null],
        'default_write_concern' => ['default_write_concern', null],
        'slow_op_threshold_ms' => ['slow_op_threshold_ms', null],
        'transaction_lifetime_limit_seconds' => ['transaction_lifetime_limit_seconds', null],
        'verbosity' => ['verbosity', null],
    ];

    public function __construct(
        public ?string $default_read_concern = null,
        public ?string $default_write_concern = null,
        public ?int $slow_op_threshold_ms = null,
        public ?int $transaction_lifetime_limit_seconds = null,
        public ?int $verbosity = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'default_read_concern' => $this->default_read_concern,
            'default_write_concern' => $this->default_write_concern,
            'slow_op_threshold_ms' => $this->slow_op_threshold_ms,
            'transaction_lifetime_limit_seconds' => $this->transaction_lifetime_limit_seconds,
            'verbosity' => $this->verbosity,
        ];
    }
}
