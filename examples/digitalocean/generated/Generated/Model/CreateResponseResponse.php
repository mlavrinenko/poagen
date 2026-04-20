<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class CreateResponseResponse
{
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
}
