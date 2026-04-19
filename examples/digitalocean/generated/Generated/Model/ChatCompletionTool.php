<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ChatCompletionTool implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'function' => ['function', \Acme\DigitalOcean\Generated\Model\FunctionObject::class],
        'type' => ['type', null],
    ];

    public function __construct(
        public FunctionObject $function,
        public string $type,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'function' => $this->function,
            'type' => $this->type,
        ];
    }
}
