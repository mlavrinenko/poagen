<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CopilotOrganizationDetails implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'public_code_suggestions' => ['public_code_suggestions', null],
        'seat_breakdown' => ['seat_breakdown', \Acme\GitHub\Generated\Model\CopilotOrganizationSeatBreakdown::class],
        'seat_management_setting' => ['seat_management_setting', null],
        'cli' => ['cli', null],
        'ide_chat' => ['ide_chat', null],
        'plan_type' => ['plan_type', null],
        'platform_chat' => ['platform_chat', null],
    ];

    public function __construct(
        public string $public_code_suggestions,
        public CopilotOrganizationSeatBreakdown $seat_breakdown,
        public string $seat_management_setting,
        public ?string $cli = null,
        public ?string $ide_chat = null,
        public ?string $plan_type = null,
        public ?string $platform_chat = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'public_code_suggestions' => $this->public_code_suggestions,
            'seat_breakdown' => $this->seat_breakdown,
            'seat_management_setting' => $this->seat_management_setting,
            'cli' => $this->cli,
            'ide_chat' => $this->ide_chat,
            'plan_type' => $this->plan_type,
            'platform_chat' => $this->platform_chat,
        ];
    }
}
