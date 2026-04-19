<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookMetaDeletedHookConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'content_type' => ['content_type', null],
        'insecure_ssl' => ['insecure_ssl', null],
        'url' => ['url', null],
        'secret' => ['secret', null],
    ];

    public function __construct(
        public string $content_type,
        public string $insecure_ssl,
        public string $url,
        public ?string $secret = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'content_type' => $this->content_type,
            'insecure_ssl' => $this->insecure_ssl,
            'url' => $this->url,
            'secret' => $this->secret,
        ];
    }
}
