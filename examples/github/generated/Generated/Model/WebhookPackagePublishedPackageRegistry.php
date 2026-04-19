<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPackagePublishedPackageRegistry implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'about_url' => ['about_url', null],
        'name' => ['name', null],
        'type' => ['type', null],
        'url' => ['url', null],
        'vendor' => ['vendor', null],
    ];

    public function __construct(
        public string $about_url,
        public string $name,
        public string $type,
        public string $url,
        public string $vendor,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'about_url' => $this->about_url,
            'name' => $this->name,
            'type' => $this->type,
            'url' => $this->url,
            'vendor' => $this->vendor,
        ];
    }
}
