<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class FileCommit implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'commit' => ['commit', \Acme\GitHub\Generated\Model\FileCommitCommit::class],
        'content' => ['content', \Acme\GitHub\Generated\Model\FileCommitContent::class],
    ];

    public function __construct(
        public FileCommitCommit $commit,
        public FileCommitContent $content,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'commit' => $this->commit,
            'content' => $this->content,
        ];
    }
}
