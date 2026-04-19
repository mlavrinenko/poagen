<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class IssuesEvent implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'action' => ['action', null],
        'issue' => ['issue', \Acme\GitHub\Generated\Model\Issue::class],
        'assignee' => ['assignee', \Acme\GitHub\Generated\Model\SimpleUser::class],
        'assignees' => ['assignees', ['list', \Acme\GitHub\Generated\Model\SimpleUser::class]],
        'label' => ['label', \Acme\GitHub\Generated\Model\Label::class],
        'labels' => ['labels', ['list', \Acme\GitHub\Generated\Model\Label::class]],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Model\SimpleUser> $assignees
     * @param ?list<\Acme\GitHub\Generated\Model\Label> $labels
     */
    public function __construct(
        public string $action,
        public Issue $issue,
        public ?SimpleUser $assignee = null,
        public ?array $assignees = null,
        public ?Label $label = null,
        public ?array $labels = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'action' => $this->action,
            'issue' => $this->issue,
            'assignee' => $this->assignee,
            'assignees' => $this->assignees,
            'label' => $this->label,
            'labels' => $this->labels,
        ];
    }
}
