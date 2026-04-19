<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsImageSourceSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'deploy_on_push' => ['deploy_on_push', \Acme\DigitalOcean\Generated\Model\AppsImageSourceSpecDeploy_on_push::class],
        'digest' => ['digest', null],
        'registry' => ['registry', null],
        'registry_credentials' => ['registry_credentials', null],
        'registry_type' => ['registry_type', null],
        'repository' => ['repository', null],
        'tag' => ['tag', null],
    ];

    public function __construct(
        public ?AppsImageSourceSpecDeploy_on_push $deploy_on_push = null,
        public ?string $digest = null,
        public ?string $registry = null,
        public ?string $registry_credentials = null,
        public ?string $registry_type = null,
        public ?string $repository = null,
        public ?string $tag = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'deploy_on_push' => $this->deploy_on_push,
            'digest' => $this->digest,
            'registry' => $this->registry,
            'registry_credentials' => $this->registry_credentials,
            'registry_type' => $this->registry_type,
            'repository' => $this->repository,
            'tag' => $this->tag,
        ];
    }
}
