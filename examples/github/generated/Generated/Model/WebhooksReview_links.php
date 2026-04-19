<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhooksReview_links implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'html' => ['html', \Acme\GitHub\Generated\Model\WebhooksReview_linksHtml::class],
        'pull_request' => ['pull_request', \Acme\GitHub\Generated\Model\WebhooksReview_linksPull_request::class],
    ];

    public function __construct(
        public WebhooksReview_linksHtml $html,
        public WebhooksReview_linksPull_request $pull_request,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'html' => $this->html,
            'pull_request' => $this->pull_request,
        ];
    }
}
