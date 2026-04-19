<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class GeneratedImage implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['b64_json' => ['b64_json', null], 'revised_prompt' => ['revised_prompt', null]];

    public function __construct(
        public string $b64_json,
        public ?string $revised_prompt = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'b64_json' => $this->b64_json,
            'revised_prompt' => $this->revised_prompt,
        ];
    }
}
