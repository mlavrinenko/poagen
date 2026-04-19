<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ChatCompletionToolCallChunk implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'function' => ['function', \Acme\DigitalOcean\Generated\Model\ChatCompletionToolCallChunkFunction::class],
        'id' => ['id', null],
        'index' => ['index', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public ?ChatCompletionToolCallChunkFunction $function = null,
        public ?string $id = null,
        public ?int $index = null,
        public ?string $type = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'function' => $this->function,
            'id' => $this->id,
            'index' => $this->index,
            'type' => $this->type,
        ];
    }
}
