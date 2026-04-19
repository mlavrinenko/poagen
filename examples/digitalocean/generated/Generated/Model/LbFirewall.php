<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class LbFirewall implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = ['allow' => ['allow', ['list', null]], 'deny' => ['deny', ['list', null]]];

    /**
     * @param ?list<string> $allow
     * @param ?list<string> $deny
     */
    public function __construct(
        public ?array $allow = null,
        public ?array $deny = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'allow' => $this->allow,
            'deny' => $this->deny,
        ];
    }
}
