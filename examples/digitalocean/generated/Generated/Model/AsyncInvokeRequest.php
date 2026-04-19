<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AsyncInvokeRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'input' => ['input', \Acme\DigitalOcean\Generated\Model\AsyncInvokeRequestInput::class],
        'model_id' => ['model_id', null],
        'tags' => ['tags', ['list', null]],
    ];

    /**
     * @param ?list<array<string, mixed>> $tags
     */
    public function __construct(
        public AsyncInvokeRequestInput $input,
        public string $model_id,
        public ?array $tags = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'input' => $this->input,
            'model_id' => $this->model_id,
            'tags' => $this->tags,
        ];
    }
}
