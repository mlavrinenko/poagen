<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\AppAlertSpecOperator;
use Acme\DigitalOcean\Generated\Enum\AppAlertSpecRule;
use Acme\DigitalOcean\Generated\Enum\AppAlertSpecWindow;
use JsonSerializable;

final readonly class AppAlertSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'disabled' => ['disabled', null],
        'operator' => ['operator', ['enum', \Acme\DigitalOcean\Generated\Enum\AppAlertSpecOperator::class]],
        'rule' => ['rule', ['enum', \Acme\DigitalOcean\Generated\Enum\AppAlertSpecRule::class]],
        'value' => ['value', null],
        'window' => ['window', ['enum', \Acme\DigitalOcean\Generated\Enum\AppAlertSpecWindow::class]],
    ];

    public function __construct(
        public ?bool $disabled = null,
        public ?AppAlertSpecOperator $operator = null,
        public ?AppAlertSpecRule $rule = null,
        public ?float $value = null,
        public ?AppAlertSpecWindow $window = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'disabled' => $this->disabled,
            'operator' => $this->operator,
            'rule' => $this->rule,
            'value' => $this->value,
            'window' => $this->window,
        ];
    }
}
