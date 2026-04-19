<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CodeSearchResultItem implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'git_url' => ['git_url', null],
        'html_url' => ['html_url', null],
        'name' => ['name', null],
        'path' => ['path', null],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\MinimalRepository::class],
        'score' => ['score', null],
        'sha' => ['sha', null],
        'url' => ['url', null],
        'file_size' => ['file_size', null],
        'language' => ['language', null],
        'last_modified_at' => ['last_modified_at', ['datetime', null]],
        'line_numbers' => ['line_numbers', ['list', null]],
        'text_matches' => ['text_matches', \Acme\GitHub\Generated\Model\SearchResultTextMatches::class],
    ];

    /**
     * @param ?list<string> $line_numbers
     */
    public function __construct(
        public string $git_url,
        public string $html_url,
        public string $name,
        public string $path,
        public MinimalRepository $repository,
        public float $score,
        public string $sha,
        public string $url,
        public ?int $file_size = null,
        public ?string $language = null,
        public ?DateTimeImmutable $last_modified_at = null,
        public ?array $line_numbers = null,
        public ?SearchResultTextMatches $text_matches = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'git_url' => $this->git_url,
            'html_url' => $this->html_url,
            'name' => $this->name,
            'path' => $this->path,
            'repository' => $this->repository,
            'score' => $this->score,
            'sha' => $this->sha,
            'url' => $this->url,
            'file_size' => $this->file_size,
            'language' => $this->language,
            'last_modified_at' => $this->last_modified_at?->format(\DateTimeInterface::RFC3339),
            'line_numbers' => $this->line_numbers,
            'text_matches' => $this->text_matches,
        ];
    }
}
