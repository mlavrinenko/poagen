<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\DbaasClusterStatus;

final readonly class ApiGetKnowledgeBaseOutput
{
    public function __construct(
        public ?DbaasClusterStatus $database_status = null,
        public ?ApiKnowledgeBase $knowledge_base = null,
    ) {
    }
}
