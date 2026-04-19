<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsDeploymentsResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'meta' => ['meta', null],
        'deployments' => ['deployments', ['list', \Acme\DigitalOcean\Generated\Model\AppsDeployment::class]],
        'links' => ['links', \Acme\DigitalOcean\Generated\Model\PageLinks::class],
    ];

    /**
     * @param mixed $meta
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppsDeployment> $deployments
     */
    public function __construct(
        public $meta,
        public ?array $deployments = null,
        public ?PageLinks $links = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'meta' => $this->meta,
            'deployments' => $this->deployments,
            'links' => $this->links,
        ];
    }
}
