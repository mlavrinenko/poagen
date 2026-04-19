<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookCodeScanningAlertReopenedByUserAlertMost_recent_instance implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'analysis_key' => ['analysis_key', null],
        'environment' => ['environment', null],
        'ref' => ['ref', null],
        'state' => ['state', null],
        'category' => ['category', null],
        'classifications' => ['classifications', ['list', null]],
        'commit_sha' => ['commit_sha', null],
        'location' => [
            'location',
            \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertReopenedByUserAlertMost_recent_instanceLocation::class,
        ],
        'message' => [
            'message',
            \Acme\GitHub\Generated\Model\WebhookCodeScanningAlertReopenedByUserAlertMost_recent_instanceMessage::class,
        ],
    ];

    /**
     * @param ?list<string> $classifications
     */
    public function __construct(
        public string $analysis_key,
        public string $environment,
        public string $ref,
        public string $state,
        public ?string $category = null,
        public ?array $classifications = null,
        public ?string $commit_sha = null,
        public ?WebhookCodeScanningAlertReopenedByUserAlertMost_recent_instanceLocation $location = null,
        public ?WebhookCodeScanningAlertReopenedByUserAlertMost_recent_instanceMessage $message = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'analysis_key' => $this->analysis_key,
            'environment' => $this->environment,
            'ref' => $this->ref,
            'state' => $this->state,
            'category' => $this->category,
            'classifications' => $this->classifications,
            'commit_sha' => $this->commit_sha,
            'location' => $this->location,
            'message' => $this->message,
        ];
    }
}
