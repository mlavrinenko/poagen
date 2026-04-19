<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class GitTag implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'message' => ['message', null],
        'node_id' => ['node_id', null],
        'object' => ['object', \Acme\GitHub\Generated\Model\GitTagObject::class],
        'sha' => ['sha', null],
        'tag' => ['tag', null],
        'tagger' => ['tagger', \Acme\GitHub\Generated\Model\GitTagTagger::class],
        'url' => ['url', null],
        'verification' => ['verification', \Acme\GitHub\Generated\Model\Verification::class],
    ];

    public function __construct(
        public string $message,
        public string $node_id,
        public GitTagObject $object,
        public string $sha,
        public string $tag,
        public GitTagTagger $tagger,
        public string $url,
        public ?Verification $verification = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'message' => $this->message,
            'node_id' => $this->node_id,
            'object' => $this->object,
            'sha' => $this->sha,
            'tag' => $this->tag,
            'tagger' => $this->tagger,
            'url' => $this->url,
            'verification' => $this->verification,
        ];
    }
}
