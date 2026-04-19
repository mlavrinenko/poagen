<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class RsyslogLogsink implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'format' => ['format', null],
        'port' => ['port', null],
        'server' => ['server', null],
        'tls' => ['tls', null],
        'ca' => ['ca', null],
        'cert' => ['cert', null],
        'key' => ['key', null],
        'logline' => ['logline', null],
        'sd' => ['sd', null],
    ];

    public function __construct(
        public string $format,
        public int $port,
        public string $server,
        public bool $tls,
        public ?string $ca = null,
        public ?string $cert = null,
        public ?string $key = null,
        public ?string $logline = null,
        public ?string $sd = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'format' => $this->format,
            'port' => $this->port,
            'server' => $this->server,
            'tls' => $this->tls,
            'ca' => $this->ca,
            'cert' => $this->cert,
            'key' => $this->key,
            'logline' => $this->logline,
            'sd' => $this->sd,
        ];
    }
}
