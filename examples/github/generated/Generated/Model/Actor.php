<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Actor implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'avatar_url' => ['avatar_url', null],
        'gravatar_id' => ['gravatar_id', null],
        'id' => ['id', null],
        'login' => ['login', null],
        'url' => ['url', null],
        'display_login' => ['display_login', null],
    ];

    public function __construct(
        public string $avatar_url,
        public ?string $gravatar_id = null,
        public int $id,
        public string $login,
        public string $url,
        public ?string $display_login = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'avatar_url' => $this->avatar_url,
            'gravatar_id' => $this->gravatar_id,
            'id' => $this->id,
            'login' => $this->login,
            'url' => $this->url,
            'display_login' => $this->display_login,
        ];
    }
}
