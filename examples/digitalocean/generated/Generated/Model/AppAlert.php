<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppAlertPhase;
use JsonSerializable;

final readonly class AppAlert implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'component_name' => ['component_name', null],
        'emails' => ['emails', ['list', \Acme\DigitalOcean\Generated\Model\AppAlertEmail::class]],
        'id' => ['id', null],
        'phase' => ['phase', ['enum', \Acme\DigitalOcean\Generated\Enum\AppAlertPhase::class]],
        'progress' => ['progress', \Acme\DigitalOcean\Generated\Model\AppAlertProgress::class],
        'slack_webhooks' => ['slack_webhooks', ['list', \Acme\DigitalOcean\Generated\Model\AppAlertSlackWebhook::class]],
        'spec' => ['spec', \Acme\DigitalOcean\Generated\Model\AppAlertSpec::class],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlertEmail> $emails
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppAlertSlackWebhook> $slack_webhooks
     */
    public function __construct(
        public ?string $component_name = null,
        public ?array $emails = null,
        public ?string $id = null,
        public ?AppAlertPhase $phase = null,
        public ?AppAlertProgress $progress = null,
        public ?array $slack_webhooks = null,
        public ?AppAlertSpec $spec = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'component_name' => $this->component_name,
            'emails' => $this->emails,
            'id' => $this->id,
            'phase' => $this->phase,
            'progress' => $this->progress,
            'slack_webhooks' => $this->slack_webhooks,
            'spec' => $this->spec,
        ];
    }
}
