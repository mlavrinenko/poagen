<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ApiGetAgentUsageOutput implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'log_insights_usage' => ['log_insights_usage', \Acme\DigitalOcean\Generated\Model\ApiResourceUsage::class],
        'usage' => ['usage', \Acme\DigitalOcean\Generated\Model\ApiResourceUsage::class],
    ];

    public function __construct(
        public ?ApiResourceUsage $log_insights_usage = null,
        public ?ApiResourceUsage $usage = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'log_insights_usage' => $this->log_insights_usage,
            'usage' => $this->usage,
        ];
    }
}
