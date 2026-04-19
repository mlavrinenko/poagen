<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiChunkingAlgorithm;
use JsonSerializable;

final readonly class ApiKbdataSource implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'aws_data_source' => ['aws_data_source', \Acme\DigitalOcean\Generated\Model\ApiAwsdataSource::class],
        'bucket_name' => ['bucket_name', null],
        'bucket_region' => ['bucket_region', null],
        'chunking_algorithm' => [
            'chunking_algorithm',
            ['enum', \Acme\DigitalOcean\Generated\Enum\ApiChunkingAlgorithm::class],
        ],
        'chunking_options' => ['chunking_options', \Acme\DigitalOcean\Generated\Model\ApiChunkingOptions::class],
        'dropbox_data_source' => ['dropbox_data_source', \Acme\DigitalOcean\Generated\Model\ApiDropboxDataSource::class],
        'file_upload_data_source' => [
            'file_upload_data_source',
            \Acme\DigitalOcean\Generated\Model\ApiFileUploadDataSource::class,
        ],
        'google_drive_data_source' => [
            'google_drive_data_source',
            \Acme\DigitalOcean\Generated\Model\ApiGoogleDriveDataSource::class,
        ],
        'item_path' => ['item_path', null],
        'spaces_data_source' => ['spaces_data_source', \Acme\DigitalOcean\Generated\Model\ApiSpacesDataSource::class],
        'web_crawler_data_source' => [
            'web_crawler_data_source',
            \Acme\DigitalOcean\Generated\Model\ApiWebCrawlerDataSource::class,
        ],
    ];

    public function __construct(
        public ?ApiAwsdataSource $aws_data_source = null,
        public ?string $bucket_name = null,
        public ?string $bucket_region = null,
        public ?ApiChunkingAlgorithm $chunking_algorithm = null,
        public ?ApiChunkingOptions $chunking_options = null,
        public ?ApiDropboxDataSource $dropbox_data_source = null,
        public ?ApiFileUploadDataSource $file_upload_data_source = null,
        public ?ApiGoogleDriveDataSource $google_drive_data_source = null,
        public ?string $item_path = null,
        public ?ApiSpacesDataSource $spaces_data_source = null,
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
            'bucket_region' => $this->bucket_region,
            'chunking_algorithm' => $this->chunking_algorithm,
            'chunking_options' => $this->chunking_options,
            'dropbox_data_source' => $this->dropbox_data_source,
            'file_upload_data_source' => $this->file_upload_data_source,
            'google_drive_data_source' => $this->google_drive_data_source,
            'item_path' => $this->item_path,
            'spaces_data_source' => $this->spaces_data_source,
            'web_crawler_data_source' => $this->web_crawler_data_source,
        ];
    }
}
