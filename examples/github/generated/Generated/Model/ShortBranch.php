<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ShortBranch implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'commit' => ['commit', \Acme\GitHub\Generated\Model\ShortBranchCommit::class],
        'name' => ['name', null],
        'protected' => ['protected', null],
        'protection' => ['protection', \Acme\GitHub\Generated\Model\BranchProtection::class],
        'protection_url' => ['protection_url', null],
    ];

    public function __construct(
        public ShortBranchCommit $commit,
        public string $name,
        public bool $protected,
        public ?BranchProtection $protection = null,
        public ?string $protection_url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'commit' => $this->commit,
            'name' => $this->name,
            'protected' => $this->protected,
            'protection' => $this->protection,
            'protection_url' => $this->protection_url,
        ];
    }
}
