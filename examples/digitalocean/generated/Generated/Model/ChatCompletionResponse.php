<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class ChatCompletionResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'choices' => ['choices', ['list', null]],
        'created' => ['created', null],
        'id' => ['id', null],
        'model' => ['model', null],
        'object' => ['object', null],
        'usage' => ['usage', \Acme\DigitalOcean\Generated\Model\CompletionUsage::class],
    ];

    /**
     * @param list<array<string, mixed>> $choices
     */
    public function __construct(
        public array $choices,
        public int $created,
        public string $id,
        public string $model,
        public string $object,
        public ?CompletionUsage $usage = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'choices' => $this->choices,
            'created' => $this->created,
            'id' => $this->id,
            'model' => $this->model,
            'object' => $this->object,
            'usage' => $this->usage,
        ];
    }
}
