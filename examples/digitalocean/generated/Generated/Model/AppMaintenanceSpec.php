<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppMaintenanceSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'archive' => ['archive', null],
        'enabled' => ['enabled', null],
        'offline_page_url' => ['offline_page_url', null],
    ];

    public function __construct(
        public ?bool $archive = null,
        public ?bool $enabled = null,
        public ?string $offline_page_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'archive' => $this->archive,
            'enabled' => $this->enabled,
            'offline_page_url' => $this->offline_page_url,
        ];
    }
}
