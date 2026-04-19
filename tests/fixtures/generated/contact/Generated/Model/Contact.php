<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Contact\Generated\Model;

use JsonSerializable;
use Mlavrinenko\Paogen\Tests\Fixtures\ValueObject\Email;

final readonly class Contact implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract. See ADR-007.
     *
     * phpName => [wireKey, shape]
     * shape is one of: null (scalar pass-through), `\FQCN::class` (model ref), ['list', null] (list<scalar>), ['list', \FQCN::class] (list<Model>), ['scalar', \FQCN::class] (ScalarBinding VO).
     *
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}}>
     */
    public const array PROPERTY_MAP = [
        'displayName' => ['display-name', null],
        'email' => ['email', ['scalar', \Mlavrinenko\Paogen\Tests\Fixtures\ValueObject\Email::class]],
        'nickname' => ['nickname', null],
        'org_id' => ['org_id', null],
    ];

    public function __construct(
        public string $displayName,
        public Email $email,
        public ?string $nickname = null,
        public ?int $org_id = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'display-name' => $this->displayName,
            'email' => $this->email->toScalar(),
            'nickname' => $this->nickname,
            'org_id' => $this->org_id,
        ];
    }
}
