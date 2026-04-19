<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ClassroomAssignmentGrade implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'assignment_name' => ['assignment_name', null],
        'assignment_url' => ['assignment_url', null],
        'github_username' => ['github_username', null],
        'points_available' => ['points_available', null],
        'points_awarded' => ['points_awarded', null],
        'roster_identifier' => ['roster_identifier', null],
        'starter_code_url' => ['starter_code_url', null],
        'student_repository_name' => ['student_repository_name', null],
        'student_repository_url' => ['student_repository_url', null],
        'submission_timestamp' => ['submission_timestamp', null],
        'group_name' => ['group_name', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'assignment_name' => $this->assignment_name,
            'assignment_url' => $this->assignment_url,
            'github_username' => $this->github_username,
            'points_available' => $this->points_available,
            'points_awarded' => $this->points_awarded,
            'roster_identifier' => $this->roster_identifier,
            'starter_code_url' => $this->starter_code_url,
            'student_repository_name' => $this->student_repository_name,
            'student_repository_url' => $this->student_repository_url,
            'submission_timestamp' => $this->submission_timestamp,
            'group_name' => $this->group_name,
        ];
    }
}
