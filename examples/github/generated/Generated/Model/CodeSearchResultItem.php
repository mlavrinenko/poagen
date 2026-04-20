<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CodeSearchResultItem
{
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
}
