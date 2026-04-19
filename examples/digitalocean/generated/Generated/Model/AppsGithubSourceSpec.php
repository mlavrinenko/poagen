<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppsGithubSourceSpec implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'branch' => ['branch', null],
        'deploy_on_push' => ['deploy_on_push', null],
        'repo' => ['repo', null],
    ];

    public function __construct(
        public ?string $branch = null,
        public ?bool $deploy_on_push = null,
        public ?string $repo = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'branch' => $this->branch,
            'deploy_on_push' => $this->deploy_on_push,
            'repo' => $this->repo,
        ];
    }
}
