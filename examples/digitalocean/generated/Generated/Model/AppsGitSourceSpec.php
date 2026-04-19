<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsGitSourceSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['branch' => ['branch', null], 'repo_clone_url' => ['repo_clone_url', null]];

    public function __construct(
        public ?string $branch = null,
        public ?string $repo_clone_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'branch' => $this->branch,
            'repo_clone_url' => $this->repo_clone_url,
        ];
    }
}
