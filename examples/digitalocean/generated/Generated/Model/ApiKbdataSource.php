<?php

declare(strict_types=1);

namespace Acme\DigitalOcean\Generated\Model;

use Acme\DigitalOcean\Generated\Enum\ApiChunkingAlgorithm;

final readonly class ApiKbdataSource
{
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
}
