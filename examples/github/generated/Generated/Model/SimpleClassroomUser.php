<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SimpleClassroomUser implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'avatar_url' => ['avatar_url', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'login' => ['login', null],
    ];

    public function __construct(
        public string $avatar_url,
        public string $html_url,
        public int $id,
        public string $login,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'avatar_url' => $this->avatar_url,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'login' => $this->login,
        ];
    }
}
