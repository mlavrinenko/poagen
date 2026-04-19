<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ForwardingRule implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'entry_port' => ['entry_port', null],
        'entry_protocol' => ['entry_protocol', null],
        'target_port' => ['target_port', null],
        'target_protocol' => ['target_protocol', null],
        'certificate_id' => ['certificate_id', null],
        'tls_passthrough' => ['tls_passthrough', null],
    ];

    public function __construct(
        public int $entry_port,
        public string $entry_protocol,
        public int $target_port,
        public string $target_protocol,
        public ?string $certificate_id = null,
        public ?bool $tls_passthrough = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'entry_port' => $this->entry_port,
            'entry_protocol' => $this->entry_protocol,
            'target_port' => $this->target_port,
            'target_protocol' => $this->target_protocol,
            'certificate_id' => $this->certificate_id,
            'tls_passthrough' => $this->tls_passthrough,
        ];
    }
}
