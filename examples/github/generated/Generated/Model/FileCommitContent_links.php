<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class FileCommitContent_links implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['git' => ['git', null], 'html' => ['html', null], 'self' => ['self', null]];

    public function __construct(
        public ?string $git = null,
        public ?string $html = null,
        public ?string $self = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'git' => $this->git,
            'html' => $this->html,
            'self' => $this->self,
        ];
    }
}
