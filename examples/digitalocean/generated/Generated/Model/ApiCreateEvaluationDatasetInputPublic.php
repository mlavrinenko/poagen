<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiEvaluationDatasetType;
use JsonSerializable;

final readonly class ApiCreateEvaluationDatasetInputPublic implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'dataset_type' => ['dataset_type', ['enum', \Acme\DigitalOcean\Generated\Enum\ApiEvaluationDatasetType::class]],
        'file_upload_dataset' => ['file_upload_dataset', \Acme\DigitalOcean\Generated\Model\ApiFileUploadDataSource::class],
        'name' => ['name', null],
    ];

    public function __construct(
        public ?ApiEvaluationDatasetType $dataset_type = null,
        public ?ApiFileUploadDataSource $file_upload_dataset = null,
        public ?string $name = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'dataset_type' => $this->dataset_type,
            'file_upload_dataset' => $this->file_upload_dataset,
            'name' => $this->name,
        ];
    }
}
