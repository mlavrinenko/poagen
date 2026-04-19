<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookTeamEditedChangesRepositoryPermissionsFrom implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['admin' => ['admin', null], 'pull' => ['pull', null], 'push' => ['push', null]];

    public function __construct(
        public ?bool $admin = null,
        public ?bool $pull = null,
        public ?bool $push = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'admin' => $this->admin,
            'pull' => $this->pull,
            'push' => $this->push,
        ];
    }
}
