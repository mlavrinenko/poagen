<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPullRequestAutoMergeEnabledPull_requestAuto_merge implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'commit_message' => ['commit_message', null],
        'commit_title' => ['commit_title', null],
        'enabled_by' => [
            'enabled_by',
            \Acme\GitHub\Generated\Model\WebhookPullRequestAutoMergeEnabledPull_requestAuto_mergeEnabled_by::class,
        ],
        'merge_method' => ['merge_method', null],
    ];

    public function __construct(
        public ?string $commit_message = null,
        public ?string $commit_title = null,
        public WebhookPullRequestAutoMergeEnabledPull_requestAuto_mergeEnabled_by $enabled_by,
        public string $merge_method,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'commit_message' => $this->commit_message,
            'commit_title' => $this->commit_title,
            'enabled_by' => $this->enabled_by,
            'merge_method' => $this->merge_method,
        ];
    }
}
