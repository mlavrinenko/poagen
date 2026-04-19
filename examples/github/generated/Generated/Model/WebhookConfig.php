<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookConfig implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'content_type' => ['content_type', \Acme\GitHub\Generated\Model\WebhookConfigContentType::class],
        'insecure_ssl' => ['insecure_ssl', \Acme\GitHub\Generated\Model\WebhookConfigInsecureSsl::class],
        'secret' => ['secret', \Acme\GitHub\Generated\Model\WebhookConfigSecret::class],
        'url' => ['url', \Acme\GitHub\Generated\Model\WebhookConfigUrl::class],
    ];

    public function __construct(
        public ?WebhookConfigContentType $content_type = null,
        public ?WebhookConfigInsecureSsl $insecure_ssl = null,
        public ?WebhookConfigSecret $secret = null,
        public ?WebhookConfigUrl $url = null,
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
            'secret' => $this->secret,
            'url' => $this->url,
        ];
    }
}
