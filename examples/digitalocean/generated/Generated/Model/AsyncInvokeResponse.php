<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class AsyncInvokeResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created_at' => ['created_at', ['datetime', null]],
        'model_id' => ['model_id', null],
        'request_id' => ['request_id', null],
        'status' => ['status', null],
        'completed_at' => ['completed_at', ['datetime', null]],
        'error' => ['error', null],
        'output' => ['output', null],
        'started_at' => ['started_at', ['datetime', null]],
    ];

    /**
     * @param ?array<string, mixed> $output
     */
    public function __construct(
        public DateTimeImmutable $created_at,
        public string $model_id,
        public string $request_id,
        public string $status,
        public ?DateTimeImmutable $completed_at = null,
        public ?string $error = null,
        public ?array $output = null,
        public ?DateTimeImmutable $started_at = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->created_at->format(\DateTimeInterface::RFC3339),
            'model_id' => $this->model_id,
            'request_id' => $this->request_id,
            'status' => $this->status,
            'completed_at' => $this->completed_at?->format(\DateTimeInterface::RFC3339),
            'error' => $this->error,
            'output' => $this->output,
            'started_at' => $this->started_at?->format(\DateTimeInterface::RFC3339),
        ];
    }
}
