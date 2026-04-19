<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookWorkflowRunRequestedWorkflow_runHead_commit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => [
            'author',
            \Acme\GitHub\Generated\Model\WebhookWorkflowRunRequestedWorkflow_runHead_commitAuthor::class,
        ],
        'committer' => [
            'committer',
            \Acme\GitHub\Generated\Model\WebhookWorkflowRunRequestedWorkflow_runHead_commitCommitter::class,
        ],
        'id' => ['id', null],
        'message' => ['message', null],
        'timestamp' => ['timestamp', null],
        'tree_id' => ['tree_id', null],
    ];

    public function __construct(
        public WebhookWorkflowRunRequestedWorkflow_runHead_commitAuthor $author,
        public WebhookWorkflowRunRequestedWorkflow_runHead_commitCommitter $committer,
        public string $id,
        public string $message,
        public string $timestamp,
        public string $tree_id,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author' => $this->author,
            'committer' => $this->committer,
            'id' => $this->id,
            'message' => $this->message,
            'timestamp' => $this->timestamp,
            'tree_id' => $this->tree_id,
        ];
    }
}
