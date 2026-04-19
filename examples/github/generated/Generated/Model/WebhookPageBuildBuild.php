<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookPageBuildBuild implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'commit' => ['commit', null],
        'created_at' => ['created_at', null],
        'duration' => ['duration', null],
        'error' => ['error', \Acme\GitHub\Generated\Model\WebhookPageBuildBuildError::class],
        'pusher' => ['pusher', \Acme\GitHub\Generated\Model\WebhookPageBuildBuildPusher::class],
        'status' => ['status', null],
        'updated_at' => ['updated_at', null],
        'url' => ['url', null],
    ];

    public function __construct(
        public ?string $commit = null,
        public string $created_at,
        public int $duration,
        public WebhookPageBuildBuildError $error,
        public WebhookPageBuildBuildPusher $pusher,
        public string $status,
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
            'commit' => $this->commit,
            'created_at' => $this->created_at,
            'duration' => $this->duration,
            'error' => $this->error,
            'pusher' => $this->pusher,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'url' => $this->url,
        ];
    }
}
