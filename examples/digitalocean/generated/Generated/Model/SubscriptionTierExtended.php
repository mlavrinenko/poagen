<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class SubscriptionTierExtended implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'eligibility_reasons' => ['eligibility_reasons', ['list', null]],
        'eligible' => ['eligible', null],
    ];

    /**
     * @param ?list<string> $eligibility_reasons
     */
    public function __construct(
        public ?array $eligibility_reasons = null,
        public ?bool $eligible = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'eligibility_reasons' => $this->eligibility_reasons,
            'eligible' => $this->eligible,
        ];
    }
}
