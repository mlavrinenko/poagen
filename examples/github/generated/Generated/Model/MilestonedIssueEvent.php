<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class MilestonedIssueEvent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'actor' => ['actor', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'commit_id' => ['commit_id', null],
        'commit_url' => ['commit_url', null],
        'created_at' => ['created_at', null],
        'event' => ['event', null],
        'id' => ['id', null],
        'milestone' => ['milestone', \Acme\GitHub\Generated\Model\MilestonedIssueEventMilestone::class],
        'node_id' => ['node_id', null],
        'performed_via_github_app' => ['performed_via_github_app', \Acme\GitHub\Generated\Model\NullableIntegration::class],
        'url' => ['url', null],
    ];

    public function __construct(
        public SimpleUser $actor,
        public ?string $commit_id = null,
        public ?string $commit_url = null,
        public string $created_at,
        public string $event,
        public int $id,
        public MilestonedIssueEventMilestone $milestone,
        public string $node_id,
        public NullableIntegration $performed_via_github_app,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'actor' => $this->actor,
            'commit_id' => $this->commit_id,
            'commit_url' => $this->commit_url,
            'created_at' => $this->created_at,
            'event' => $this->event,
            'id' => $this->id,
            'milestone' => $this->milestone,
            'node_id' => $this->node_id,
            'performed_via_github_app' => $this->performed_via_github_app,
            'url' => $this->url,
        ];
    }
}
