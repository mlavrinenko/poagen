<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use JsonSerializable;

final readonly class AppJobInvocations implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'job_invocations' => ['job_invocations', ['list', \Acme\DigitalOcean\Generated\Model\AppJobInvocation::class]],
        'links' => ['links', \Acme\DigitalOcean\Generated\Model\PageLinks::class],
    ];

    /**
     * @param ?list<\Acme\DigitalOcean\Generated\Model\AppJobInvocation> $job_invocations
     */
    public function __construct(
        public ?array $job_invocations = null,
        public ?PageLinks $links = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'job_invocations' => $this->job_invocations,
            'links' => $this->links,
        ];
    }
}
