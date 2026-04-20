<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiEvaluationDatasetType;

final readonly class ApiCreateEvaluationDatasetInputPublic
{
    public function __construct(
        public ?ApiEvaluationDatasetType $dataset_type = null,
        public ?ApiFileUploadDataSource $file_upload_dataset = null,
        public ?string $name = null,
    ) {
    }
}
