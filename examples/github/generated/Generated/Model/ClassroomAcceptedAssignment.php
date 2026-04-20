<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class ClassroomAcceptedAssignment
{
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
}
