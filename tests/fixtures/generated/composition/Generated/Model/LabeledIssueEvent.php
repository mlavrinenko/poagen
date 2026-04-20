<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Tests\Fixtures\Generated\Composition\Generated\Model;

final readonly class LabeledIssueEvent implements IssueEventForIssue
{
    public function __construct(
        public string $label,
    ) {
    }
}
