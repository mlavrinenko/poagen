<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiEvaluationMetricValueType;
use JsonSerializable;

final readonly class ApiEvaluationMetricResult implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'error_description' => ['error_description', null],
        'metric_name' => ['metric_name', null],
        'metric_value_type' => [
            'metric_value_type',
            ['enum', \Acme\DigitalOcean\Generated\Enum\ApiEvaluationMetricValueType::class],
        ],
        'number_value' => ['number_value', null],
        'reasoning' => ['reasoning', null],
        'string_value' => ['string_value', null],
    ];

    public function __construct(
        public ?string $error_description = null,
        public ?string $metric_name = null,
        public ?ApiEvaluationMetricValueType $metric_value_type = null,
        public ?float $number_value = null,
        public ?string $reasoning = null,
        public ?string $string_value = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'error_description' => $this->error_description,
            'metric_name' => $this->metric_name,
            'metric_value_type' => $this->metric_value_type,
            'number_value' => $this->number_value,
            'reasoning' => $this->reasoning,
            'string_value' => $this->string_value,
        ];
    }
}
