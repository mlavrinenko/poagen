<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

final readonly class CreateResponseRequest
{
    /**
     * @param mixed $input
     * @param ?array<string, string> $metadata
     * @param ?mixed $stop
     * @param ?mixed $tool_choice
     * @param ?list<array<string, mixed>> $tools
     */
    public function __construct(
        public $input,
        public string $model,
        public ?string $instructions = null,
        public ?int $max_output_tokens = null,
        public ?array $metadata = null,
        public $stop = null,
        public ?bool $stream = null,
        public ?CreateResponseRequestStream_options $stream_options = null,
        public ?float $temperature = null,
        public $tool_choice = null,
        public ?array $tools = null,
        public ?float $top_p = null,
        public ?string $user = null,
    ) {
    }
}
