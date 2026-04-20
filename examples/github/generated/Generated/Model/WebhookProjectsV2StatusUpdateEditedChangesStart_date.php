<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use Mlavrinenko\Paogen\Runtime\Attribute\Format;

final readonly class WebhookProjectsV2StatusUpdateEditedChangesStart_date
{
    public function __construct(
        #[Format('date')]
        public ?DateTimeImmutable $from = null,
        #[Format('date')]
        public ?DateTimeImmutable $to = null,
    ) {
    }
}
