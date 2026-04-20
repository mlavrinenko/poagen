<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class GitTag
{
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
}
