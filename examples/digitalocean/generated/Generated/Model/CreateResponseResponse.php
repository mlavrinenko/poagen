<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class CreateResponseResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'created' => ['created', null],
        'id' => ['id', null],
        'model' => ['model', null],
        'object' => ['object', null],
        'output' => ['output', ['list', null]],
        'usage' => ['usage', \Acme\DigitalOcean\Generated\Model\ResponseUsage::class],
        'max_output_tokens' => ['max_output_tokens', null],
        'parallel_tool_calls' => ['parallel_tool_calls', null],
        'status' => ['status', null],
        'temperature' => ['temperature', null],
        'tool_choice' => ['tool_choice', null],
        'tools' => ['tools', ['list', null]],
        'top_p' => ['top_p', null],
        'user' => ['user', null],
    ];

    /**
     * @param list<array<string, mixed>> $output
     * @param ?list<array<string, mixed>> $tools
     */
    public function __construct(
        public int $created,
        public string $id,
        public string $model,
        public string $object,
        public array $output,
        public ResponseUsage $usage,
        public ?int $max_output_tokens = null,
        public ?bool $parallel_tool_calls = null,
        public ?string $status = null,
        public ?float $temperature = null,
        public ?string $tool_choice = null,
        public ?array $tools = null,
        public ?float $top_p = null,
        public ?string $user = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'created' => $this->created,
            'id' => $this->id,
            'model' => $this->model,
            'object' => $this->object,
            'output' => $this->output,
            'usage' => $this->usage,
            'max_output_tokens' => $this->max_output_tokens,
            'parallel_tool_calls' => $this->parallel_tool_calls,
            'status' => $this->status,
            'temperature' => $this->temperature,
            'tool_choice' => $this->tool_choice,
            'tools' => $this->tools,
            'top_p' => $this->top_p,
            'user' => $this->user,
        ];
    }
}
