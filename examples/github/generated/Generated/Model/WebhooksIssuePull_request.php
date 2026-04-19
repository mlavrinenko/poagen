<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class WebhooksIssuePull_request implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'diff_url' => ['diff_url', null],
        'html_url' => ['html_url', null],
        'merged_at' => ['merged_at', ['datetime', null]],
        'patch_url' => ['patch_url', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public ?string $diff_url = null,
        public ?string $html_url = null,
        public ?DateTimeImmutable $merged_at = null,
        public ?string $patch_url = null,
        public ?string $url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'diff_url' => $this->diff_url,
            'html_url' => $this->html_url,
            'merged_at' => $this->merged_at?->format(\DateTimeInterface::RFC3339),
            'patch_url' => $this->patch_url,
            'url' => $this->url,
        ];
    }
}
