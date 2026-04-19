<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsAssignAppAlertDestinationsRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'emails' => ['emails', ['list', \Acme\DigitalOcean\Generated\Model\AppAlertEmail::class]],
        'slack_webhooks' => ['slack_webhooks', ['list', \Acme\DigitalOcean\Generated\Model\AppAlertSlackWebhook::class]],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlertEmail> $emails
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlertSlackWebhook> $slack_webhooks
     */
    public function __construct(
        public ?array $emails = null,
        public ?array $slack_webhooks = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'emails' => $this->emails,
            'slack_webhooks' => $this->slack_webhooks,
        ];
    }
}
