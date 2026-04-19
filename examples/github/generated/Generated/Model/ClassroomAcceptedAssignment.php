<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class ClassroomAcceptedAssignment implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'assignment' => ['assignment', \Acme\GitHub\Generated\Model\SimpleClassroomAssignment::class],
        'commit_count' => ['commit_count', null],
        'grade' => ['grade', null],
        'id' => ['id', null],
        'passing' => ['passing', null],
        'repository' => ['repository', \Acme\GitHub\Generated\Model\SimpleClassroomRepository::class],
        'students' => ['students', ['list', \Acme\GitHub\Generated\Model\SimpleClassroomUser::class]],
        'submitted' => ['submitted', null],
    ];

    /**
     * @param list<\Acme\GitHub\Generated\Model\SimpleClassroomUser> $students
     */
    public function __construct(
        public SimpleClassroomAssignment $assignment,
        public int $commit_count,
        public string $grade,
        public int $id,
        public bool $passing,
        public SimpleClassroomRepository $repository,
        public array $students,
        public bool $submitted,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'assignment' => $this->assignment,
            'commit_count' => $this->commit_count,
            'grade' => $this->grade,
            'id' => $this->id,
            'passing' => $this->passing,
            'repository' => $this->repository,
            'students' => $this->students,
            'submitted' => $this->submitted,
        ];
    }
}
