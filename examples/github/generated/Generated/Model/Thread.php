<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Thread implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'id' => ['id', null],
        'last_read_at' => ['last_read_at', null],
        'reason' => ['reason', null],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\MinimalRepository::class],
        'subject' => ['subject', \Acme\GitHub\Generated\Model\ThreadSubject::class],
        'subscription_url' => ['subscription_url', null],
        'unread' => ['unread', null],
        'updated_at' => ['updated_at', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public string $id,
        public ?string $last_read_at = null,
        public string $reason,
        public MinimalRepository $repository,
        public ThreadSubject $subject,
        public string $subscription_url,
        public bool $unread,
        public string $updated_at,
        public string $url,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'last_read_at' => $this->last_read_at,
            'reason' => $this->reason,
            'repository' => $this->repository,
            'subject' => $this->subject,
            'subscription_url' => $this->subscription_url,
            'unread' => $this->unread,
            'updated_at' => $this->updated_at,
            'url' => $this->url,
        ];
    }
}
