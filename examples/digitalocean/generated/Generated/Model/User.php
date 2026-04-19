<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class User implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'kubernetes_cluster_user' => [
            'kubernetes_cluster_user',
            \Acme\DigitalOcean\Generated\Model\UserKubernetes_cluster_user::class,
        ],
    ];

    public function __construct(
        public ?UserKubernetes_cluster_user $kubernetes_cluster_user = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'kubernetes_cluster_user' => $this->kubernetes_cluster_user,
        ];
    }
}
