<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RuleSuitePullRequest implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'pull_request' => ['pull_request', \Acme\GitHub\Generated\Model\RuleSuitePullRequestPull_request::class],
    ];

    public function __construct(
        public ?RuleSuitePullRequestPull_request $pull_request = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'pull_request' => $this->pull_request,
        ];
    }
}
