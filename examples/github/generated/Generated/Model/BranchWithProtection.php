<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class BranchWithProtection implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        '_links' => ['_links', \Acme\GitHub\Generated\Model\BranchWithProtection_links::class],
        'commit' => ['commit', \Acme\GitHub\Generated\Model\Commit::class],
        'name' => ['name', null],
        'protected' => ['protected', null],
        'protection' => ['protection', \Acme\GitHub\Generated\Model\BranchProtection::class],
        'protection_url' => ['protection_url', null],
        'pattern' => ['pattern', null],
        'required_approving_review_count' => ['required_approving_review_count', null],
    ];

    public function __construct(
        public BranchWithProtection_links $_links,
        public Commit $commit,
        public string $name,
        public bool $protected,
        public BranchProtection $protection,
        public string $protection_url,
        public ?string $pattern = null,
        public ?int $required_approving_review_count = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            '_links' => $this->_links,
            'commit' => $this->commit,
            'name' => $this->name,
            'protected' => $this->protected,
            'protection' => $this->protection,
            'protection_url' => $this->protection_url,
            'pattern' => $this->pattern,
            'required_approving_review_count' => $this->required_approving_review_count,
        ];
    }
}
