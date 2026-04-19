<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsUpdateAppRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'spec' => ['spec', \Acme\DigitalOcean\Generated\Model\AppSpec::class],
        'update_all_source_versions' => ['update_all_source_versions', null],
    ];

    public function __construct(
        public AppSpec $spec,
        public ?bool $update_all_source_versions = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'spec' => $this->spec,
            'update_all_source_versions' => $this->update_all_source_versions,
        ];
    }
}
