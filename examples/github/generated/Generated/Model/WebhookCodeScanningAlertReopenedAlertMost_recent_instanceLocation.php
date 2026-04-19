<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookCodeScanningAlertReopenedAlertMost_recent_instanceLocation implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'end_column' => ['end_column', null],
        'end_line' => ['end_line', null],
        'path' => ['path', null],
        'start_column' => ['start_column', null],
        'start_line' => ['start_line', null],
    ];

    public function __construct(
        public ?int $end_column = null,
        public ?int $end_line = null,
        public ?string $path = null,
        public ?int $start_column = null,
        public ?int $start_line = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'end_column' => $this->end_column,
            'end_line' => $this->end_line,
            'path' => $this->path,
            'start_column' => $this->start_column,
            'start_line' => $this->start_line,
        ];
    }
}
