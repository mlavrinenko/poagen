<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookSponsorshipEditedChanges implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'privacy_level' => [
            'privacy_level',
            \Acme\GitHub\Generated\Model\WebhookSponsorshipEditedChangesPrivacy_level::class,
        ],
    ];

    public function __construct(
        public ?WebhookSponsorshipEditedChangesPrivacy_level $privacy_level = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'privacy_level' => $this->privacy_level,
        ];
    }
}
