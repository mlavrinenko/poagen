<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ImagesUsageInput_tokens_details implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['image_tokens' => ['image_tokens', null], 'text_tokens' => ['text_tokens', null]];

    public function __construct(
        public int $image_tokens,
        public int $text_tokens,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'image_tokens' => $this->image_tokens,
            'text_tokens' => $this->text_tokens,
        ];
    }
}
