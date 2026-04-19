<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class DedicatedInferenceCreateRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'spec' => ['spec', \Acme\DigitalOcean\Generated\Model\DedicatedInferenceSpec::class],
        'access_tokens' => ['access_tokens', null],
    ];

    /**
     * @param ?array<string, string> $access_tokens
     */
    public function __construct(
        public DedicatedInferenceSpec $spec,
        public ?array $access_tokens = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'spec' => $this->spec,
            'access_tokens' => $this->access_tokens,
        ];
    }
}
