<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class TeamPermissions implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'admin' => ['admin', null],
        'maintain' => ['maintain', null],
        'pull' => ['pull', null],
        'push' => ['push', null],
        'triage' => ['triage', null],
    ];

    public function __construct(
        public bool $admin,
        public bool $maintain,
        public bool $pull,
        public bool $push,
        public bool $triage,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'admin' => $this->admin,
            'maintain' => $this->maintain,
            'pull' => $this->pull,
            'push' => $this->push,
            'triage' => $this->triage,
        ];
    }
}
