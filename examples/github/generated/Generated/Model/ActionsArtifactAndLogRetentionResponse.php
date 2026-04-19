<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ActionsArtifactAndLogRetentionResponse implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['days' => ['days', null], 'maximum_allowed_days' => ['maximum_allowed_days', null]];

    public function __construct(
        public int $days,
        public int $maximum_allowed_days,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'days' => $this->days,
            'maximum_allowed_days' => $this->maximum_allowed_days,
        ];
    }
}
