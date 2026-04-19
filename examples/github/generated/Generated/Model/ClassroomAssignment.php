<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class ClassroomAssignment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'accepted' => ['accepted', null],
        'classroom' => ['classroom', \Acme\GitHub\Generated\Model\Classroom::class],
        'deadline' => ['deadline', ['datetime', null]],
        'editor' => ['editor', null],
        'feedback_pull_requests_enabled' => ['feedback_pull_requests_enabled', null],
        'id' => ['id', null],
        'invitations_enabled' => ['invitations_enabled', null],
        'invite_link' => ['invite_link', null],
        'language' => ['language', null],
        'max_members' => ['max_members', null],
        'max_teams' => ['max_teams', null],
        'passing' => ['passing', null],
        'public_repo' => ['public_repo', null],
        'slug' => ['slug', null],
        'starter_code_repository' => [
            'starter_code_repository',
            \Acme\GitHub\Generated\Model\SimpleClassroomRepository::class,
        ],
        'students_are_repo_admins' => ['students_are_repo_admins', null],
        'submitted' => ['submitted', null],
        'title' => ['title', null],
        'type' => ['type', null],
    ];

    public function __construct(
        public int $accepted,
        public Classroom $classroom,
        public ?DateTimeImmutable $deadline = null,
        public string $editor,
        public bool $feedback_pull_requests_enabled,
        public int $id,
        public bool $invitations_enabled,
        public string $invite_link,
        public string $language,
        public ?int $max_members = null,
        public ?int $max_teams = null,
        public int $passing,
        public bool $public_repo,
        public string $slug,
        public SimpleClassroomRepository $starter_code_repository,
        public bool $students_are_repo_admins,
        public int $submitted,
        public string $title,
        public string $type,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'accepted' => $this->accepted,
            'classroom' => $this->classroom,
            'deadline' => $this->deadline?->format(\DateTimeInterface::RFC3339),
            'editor' => $this->editor,
            'feedback_pull_requests_enabled' => $this->feedback_pull_requests_enabled,
            'id' => $this->id,
            'invitations_enabled' => $this->invitations_enabled,
            'invite_link' => $this->invite_link,
            'language' => $this->language,
            'max_members' => $this->max_members,
            'max_teams' => $this->max_teams,
            'passing' => $this->passing,
            'public_repo' => $this->public_repo,
            'slug' => $this->slug,
            'starter_code_repository' => $this->starter_code_repository,
            'students_are_repo_admins' => $this->students_are_repo_admins,
            'submitted' => $this->submitted,
            'title' => $this->title,
            'type' => $this->type,
        ];
    }
}
