<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class CopilotUsageMetrics28DayReport
{
    /**
     * @param list<string> $download_links
     */
    public function __construct(
        public array $download_links,
        #[Format('date')]
        public DateTimeImmutable $report_end_day,
        #[Format('date')]
        public DateTimeImmutable $report_start_day,
    ) {
    }
}
