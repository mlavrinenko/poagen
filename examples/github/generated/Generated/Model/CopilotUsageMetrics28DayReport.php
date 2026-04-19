<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CopilotUsageMetrics28DayReport implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'download_links' => ['download_links', ['list', null]],
        'report_end_day' => ['report_end_day', ['date', null]],
        'report_start_day' => ['report_start_day', ['date', null]],
    ];

    /**
     * @param list<string> $download_links
     */
    public function __construct(
        public array $download_links,
        public DateTimeImmutable $report_end_day,
        public DateTimeImmutable $report_start_day,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'download_links' => $this->download_links,
            'report_end_day' => $this->report_end_day->format('Y-m-d'),
            'report_start_day' => $this->report_start_day->format('Y-m-d'),
        ];
    }
}
