<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CheckAnnotation implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'annotation_level' => ['annotation_level', null],
        'blob_href' => ['blob_href', null],
        'end_column' => ['end_column', null],
        'end_line' => ['end_line', null],
        'message' => ['message', null],
        'path' => ['path', null],
        'raw_details' => ['raw_details', null],
        'start_column' => ['start_column', null],
        'start_line' => ['start_line', null],
        'title' => ['title', null],
    ];

    public function __construct(
        public ?string $annotation_level = null,
        public string $blob_href,
        public ?int $end_column = null,
        public int $end_line,
        public ?string $message = null,
        public string $path,
        public ?string $raw_details = null,
        public ?int $start_column = null,
        public int $start_line,
        public ?string $title = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'annotation_level' => $this->annotation_level,
            'blob_href' => $this->blob_href,
            'end_column' => $this->end_column,
            'end_line' => $this->end_line,
            'message' => $this->message,
            'path' => $this->path,
            'raw_details' => $this->raw_details,
            'start_column' => $this->start_column,
            'start_line' => $this->start_line,
            'title' => $this->title,
        ];
    }
}
