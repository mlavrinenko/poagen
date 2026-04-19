<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DedicatedInferenceUpdateRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'access_tokens' => [
            'access_tokens',
            \Acme\DigitalOcean\Generated\Model\DedicatedInferenceUpdateRequestAccess_tokens::class,
        ],
        'spec' => ['spec', \Acme\DigitalOcean\Generated\Model\DedicatedInferenceSpec::class],
    ];

    public function __construct(
        public ?DedicatedInferenceUpdateRequestAccess_tokens $access_tokens = null,
        public ?DedicatedInferenceSpec $spec = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'access_tokens' => $this->access_tokens,
            'spec' => $this->spec,
        ];
    }
}
