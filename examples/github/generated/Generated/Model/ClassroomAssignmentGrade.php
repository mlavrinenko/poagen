<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ClassroomAssignmentGrade
{
    public function __construct(
        public string $assignment_name,
        public string $assignment_url,
        public string $github_username,
        public int $points_available,
        public int $points_awarded,
        public string $roster_identifier,
        public string $starter_code_url,
        public string $student_repository_name,
        public string $student_repository_url,
        public string $submission_timestamp,
        public ?string $group_name = null,
    ) {
    }
}
