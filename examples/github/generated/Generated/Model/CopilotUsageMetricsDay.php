<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CopilotUsageMetricsDay implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'date' => ['date', ['date', null]],
        'copilot_dotcom_chat' => ['copilot_dotcom_chat', \Acme\GitHub\Generated\Model\CopilotDotcomChat::class],
        'copilot_dotcom_pull_requests' => [
            'copilot_dotcom_pull_requests',
            \Acme\GitHub\Generated\Model\CopilotDotcomPullRequests::class,
        ],
        'copilot_ide_chat' => ['copilot_ide_chat', \Acme\GitHub\Generated\Model\CopilotIdeChat::class],
        'copilot_ide_code_completions' => [
            'copilot_ide_code_completions',
            \Acme\GitHub\Generated\Model\CopilotIdeCodeCompletions::class,
        ],
        'total_active_users' => ['total_active_users', null],
        'total_engaged_users' => ['total_engaged_users', null],
    ];

    public function __construct(
        public DateTimeImmutable $date,
        public ?CopilotDotcomChat $copilot_dotcom_chat = null,
        public ?CopilotDotcomPullRequests $copilot_dotcom_pull_requests = null,
        public ?CopilotIdeChat $copilot_ide_chat = null,
        public ?CopilotIdeCodeCompletions $copilot_ide_code_completions = null,
        public ?int $total_active_users = null,
        public ?int $total_engaged_users = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'date' => $this->date->format('Y-m-d'),
            'copilot_dotcom_chat' => $this->copilot_dotcom_chat,
            'copilot_dotcom_pull_requests' => $this->copilot_dotcom_pull_requests,
            'copilot_ide_chat' => $this->copilot_ide_chat,
            'copilot_ide_code_completions' => $this->copilot_ide_code_completions,
            'total_active_users' => $this->total_active_users,
            'total_engaged_users' => $this->total_engaged_users,
        ];
    }
}
