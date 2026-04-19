<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPullRequestUnlockedPull_requestBase implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'label' => ['label', null],
        'ref' => ['ref', null],
        'repo' => ['repo', \Acme\GitHub\Generated\Model\WebhookPullRequestUnlockedPull_requestBaseRepo::class],
        'sha' => ['sha', null],
        'user' => ['user', \Acme\GitHub\Generated\Model\WebhookPullRequestUnlockedPull_requestBaseUser::class],
    ];

    public function __construct(
        public string $label,
        public string $ref,
        public WebhookPullRequestUnlockedPull_requestBaseRepo $repo,
        public string $sha,
        public WebhookPullRequestUnlockedPull_requestBaseUser $user,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'label' => $this->label,
            'ref' => $this->ref,
            'repo' => $this->repo,
            'sha' => $this->sha,
            'user' => $this->user,
        ];
    }
}
