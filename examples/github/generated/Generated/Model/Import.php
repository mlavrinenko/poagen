<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class Import
{
    /**
     * @param ?list<array<string, mixed>> $project_choices
     */
    public function __construct(
        public string $authors_url,
        public string $html_url,
        public string $repository_url,
        public string $status,
        public string $url,
        public ?string $vcs = null,
        public string $vcs_url,
        public ?int $authors_count = null,
        public ?int $commit_count = null,
        public ?string $error_message = null,
        public ?string $failed_step = null,
        public ?bool $has_large_files = null,
        public ?int $import_percent = null,
        public ?int $large_files_count = null,
        public ?int $large_files_size = null,
        public ?string $message = null,
        public ?array $project_choices = null,
        public ?int $push_percent = null,
        public ?string $status_text = null,
        public ?string $svc_root = null,
        public ?string $svn_root = null,
        public ?string $tfvc_project = null,
        public ?bool $use_lfs = null,
    ) {
    }
}
