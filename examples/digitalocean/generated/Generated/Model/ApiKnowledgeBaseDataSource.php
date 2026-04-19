<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiChunkingAlgorithm;
use DateTimeImmutable;
use JsonSerializable;

final readonly class ApiKnowledgeBaseDataSource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'aws_data_source' => ['aws_data_source', \Acme\DigitalOcean\Generated\Model\ApiAwsdataSourceDisplay::class],
        'bucket_name' => ['bucket_name', null],
        'chunking_algorithm' => [
            'chunking_algorithm',
            ['enum', \Acme\DigitalOcean\Generated\Enum\ApiChunkingAlgorithm::class],
        ],
        'chunking_options' => ['chunking_options', \Acme\DigitalOcean\Generated\Model\ApiChunkingOptions::class],
        'created_at' => ['created_at', ['datetime', null]],
        'dropbox_data_source' => [
            'dropbox_data_source',
            \Acme\DigitalOcean\Generated\Model\ApiDropboxDataSourceDisplay::class,
        ],
        'file_upload_data_source' => [
            'file_upload_data_source',
            \Acme\DigitalOcean\Generated\Model\ApiFileUploadDataSource::class,
        ],
        'google_drive_data_source' => [
            'google_drive_data_source',
            \Acme\DigitalOcean\Generated\Model\ApiGoogleDriveDataSourceDisplay::class,
        ],
        'item_path' => ['item_path', null],
        'last_datasource_indexing_job' => [
            'last_datasource_indexing_job',
            \Acme\DigitalOcean\Generated\Model\ApiIndexedDataSource::class,
        ],
        'region' => ['region', null],
        'spaces_data_source' => ['spaces_data_source', \Acme\DigitalOcean\Generated\Model\ApiSpacesDataSource::class],
        'updated_at' => ['updated_at', ['datetime', null]],
        'uuid' => ['uuid', null],
        'web_crawler_data_source' => [
            'web_crawler_data_source',
            \Acme\DigitalOcean\Generated\Model\ApiWebCrawlerDataSource::class,
        ],
    ];

    public function __construct(
        public ?ApiAwsdataSourceDisplay $aws_data_source = null,
        public ?string $bucket_name = null,
        public ?ApiChunkingAlgorithm $chunking_algorithm = null,
        public ?ApiChunkingOptions $chunking_options = null,
        public ?DateTimeImmutable $created_at = null,
        public ?ApiDropboxDataSourceDisplay $dropbox_data_source = null,
        public ?ApiFileUploadDataSource $file_upload_data_source = null,
        public ?ApiGoogleDriveDataSourceDisplay $google_drive_data_source = null,
        public ?string $item_path = null,
        public ?ApiIndexedDataSource $last_datasource_indexing_job = null,
        public ?string $region = null,
        public ?ApiSpacesDataSource $spaces_data_source = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $uuid = null,
        public ?ApiWebCrawlerDataSource $web_crawler_data_source = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'aws_data_source' => $this->aws_data_source,
            'bucket_name' => $this->bucket_name,
            'chunking_algorithm' => $this->chunking_algorithm,
            'chunking_options' => $this->chunking_options,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'dropbox_data_source' => $this->dropbox_data_source,
            'file_upload_data_source' => $this->file_upload_data_source,
            'google_drive_data_source' => $this->google_drive_data_source,
            'item_path' => $this->item_path,
            'last_datasource_indexing_job' => $this->last_datasource_indexing_job,
            'region' => $this->region,
            'spaces_data_source' => $this->spaces_data_source,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'uuid' => $this->uuid,
            'web_crawler_data_source' => $this->web_crawler_data_source,
        ];
    }
}
