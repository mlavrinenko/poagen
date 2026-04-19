<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiListAgentsByOpenAikeyOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'agents' => ['agents', ['list', \Acme\DigitalOcean\Generated\Model\ApiAgent::class]],
        'links' => ['links', \Acme\DigitalOcean\Generated\Model\ApiLinks::class],
        'meta' => ['meta', \Acme\DigitalOcean\Generated\Model\ApiMeta::class],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\ApiAgent> $agents
     */
    public function __construct(
        public ?array $agents = null,
        public ?ApiLinks $links = null,
        public ?ApiMeta $meta = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'agents' => $this->agents,
            'links' => $this->links,
            'meta' => $this->meta,
        ];
    }
}
