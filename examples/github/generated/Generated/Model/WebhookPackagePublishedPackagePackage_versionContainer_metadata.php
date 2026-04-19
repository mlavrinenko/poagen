<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPackagePublishedPackagePackage_versionContainer_metadata implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'labels' => ['labels', null],
        'manifest' => ['manifest', null],
        'tag' => [
            'tag',
            \Acme\GitHub\Generated\Model\WebhookPackagePublishedPackagePackage_versionContainer_metadataTag::class,
        ],
    ];

    /**
     * @param ?array<string, mixed> $labels
     * @param ?array<string, mixed> $manifest
     */
    public function __construct(
        public ?array $labels = null,
        public ?array $manifest = null,
        public ?WebhookPackagePublishedPackagePackage_versionContainer_metadataTag $tag = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'labels' => $this->labels,
            'manifest' => $this->manifest,
            'tag' => $this->tag,
        ];
    }
}
