<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppLogDestinationDefinition implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'name' => ['name', null],
        'datadog' => ['datadog', \Acme\DigitalOcean\Generated\Model\AppLogDestinationDatadogSpec::class],
        'logtail' => ['logtail', \Acme\DigitalOcean\Generated\Model\AppLogDestinationLogtailSpec::class],
        'open_search' => ['open_search', \Acme\DigitalOcean\Generated\Model\AppLogDestinationOpenSearchSpec::class],
        'papertrail' => ['papertrail', \Acme\DigitalOcean\Generated\Model\AppLogDestinationPapertrailSpec::class],
    ];

    public function __construct(
        public string $name,
        public ?AppLogDestinationDatadogSpec $datadog = null,
        public ?AppLogDestinationLogtailSpec $logtail = null,
        public ?AppLogDestinationOpenSearchSpec $open_search = null,
        public ?AppLogDestinationPapertrailSpec $papertrail = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'datadog' => $this->datadog,
            'logtail' => $this->logtail,
            'open_search' => $this->open_search,
            'papertrail' => $this->papertrail,
        ];
    }
}
