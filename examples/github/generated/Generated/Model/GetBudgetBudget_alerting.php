<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class GetBudgetBudget_alerting implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'alert_recipients' => ['alert_recipients', ['list', null]],
        'will_alert' => ['will_alert', null],
    ];

    /**
     * @param ?list<string> $alert_recipients
     */
    public function __construct(
        public ?array $alert_recipients = null,
        public ?bool $will_alert = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'alert_recipients' => $this->alert_recipients,
            'will_alert' => $this->will_alert,
        ];
    }
}
