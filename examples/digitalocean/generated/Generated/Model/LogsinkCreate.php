<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class LogsinkCreate implements JsonSerializable
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
                    \Acme\DigitalOcean\Generated\Model\RsyslogLogsink::class,
                    \Acme\DigitalOcean\Generated\Model\ElasticsearchLogsink::class,
                    \Acme\DigitalOcean\Generated\Model\OpensearchLogsink::class,
                    \Acme\DigitalOcean\Generated\Model\DatadogLogsink::class,
                ],
                null,
            ],
        ],
        'sink_name' => ['sink_name', null],
        'sink_type' => ['sink_type', null],
    ];

    public function __construct(
        public RsyslogLogsink|ElasticsearchLogsink|OpensearchLogsink|DatadogLogsink|null $config = null,
        public ?string $sink_name = null,
        public ?string $sink_type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'config' => $this->config,
            'sink_name' => $this->sink_name,
            'sink_type' => $this->sink_type,
        ];
    }
}
