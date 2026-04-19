<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsGetLogsResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'historic_urls' => ['historic_urls', ['list', null]],
        'live_url' => ['live_url', null],
    ];

    /**
     * @param ?list<string> $historic_urls
     */
    public function __construct(
        public ?array $historic_urls = null,
        public ?string $live_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'historic_urls' => $this->historic_urls,
            'live_url' => $this->live_url,
        ];
    }
}
