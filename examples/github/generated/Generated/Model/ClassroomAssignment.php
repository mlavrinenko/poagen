<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class ClassroomAssignment
{
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
}
