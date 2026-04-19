<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppIngressSpecRule implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'component' => ['component', \Acme\DigitalOcean\Generated\Model\AppIngressSpecRuleRoutingComponent::class],
        'cors' => ['cors', \Acme\DigitalOcean\Generated\Model\AppsCorsPolicy::class],
        'match' => ['match', \Acme\DigitalOcean\Generated\Model\AppIngressSpecRuleMatch::class],
        'redirect' => ['redirect', \Acme\DigitalOcean\Generated\Model\AppIngressSpecRuleRoutingRedirect::class],
    ];

    public function __construct(
        public ?AppIngressSpecRuleRoutingComponent $component = null,
        public ?AppsCorsPolicy $cors = null,
        public ?AppIngressSpecRuleMatch $match = null,
        public ?AppIngressSpecRuleRoutingRedirect $redirect = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'component' => $this->component,
            'cors' => $this->cors,
            'match' => $this->match,
            'redirect' => $this->redirect,
        ];
    }
}
