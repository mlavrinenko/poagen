<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class Import implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'authors_url' => ['authors_url', null],
        'html_url' => ['html_url', null],
        'repository_url' => ['repository_url', null],
        'status' => ['status', null],
        'url' => ['url', null],
        'vcs' => ['vcs', null],
        'vcs_url' => ['vcs_url', null],
        'authors_count' => ['authors_count', null],
        'commit_count' => ['commit_count', null],
        'error_message' => ['error_message', null],
        'failed_step' => ['failed_step', null],
        'has_large_files' => ['has_large_files', null],
        'import_percent' => ['import_percent', null],
        'large_files_count' => ['large_files_count', null],
        'large_files_size' => ['large_files_size', null],
        'message' => ['message', null],
        'project_choices' => ['project_choices', ['list', null]],
        'push_percent' => ['push_percent', null],
        'status_text' => ['status_text', null],
        'svc_root' => ['svc_root', null],
        'svn_root' => ['svn_root', null],
        'tfvc_project' => ['tfvc_project', null],
        'use_lfs' => ['use_lfs', null],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'authors_url' => $this->authors_url,
            'html_url' => $this->html_url,
            'repository_url' => $this->repository_url,
            'status' => $this->status,
            'url' => $this->url,
            'vcs' => $this->vcs,
            'vcs_url' => $this->vcs_url,
            'authors_count' => $this->authors_count,
            'commit_count' => $this->commit_count,
            'error_message' => $this->error_message,
            'failed_step' => $this->failed_step,
            'has_large_files' => $this->has_large_files,
            'import_percent' => $this->import_percent,
            'large_files_count' => $this->large_files_count,
            'large_files_size' => $this->large_files_size,
            'message' => $this->message,
            'project_choices' => $this->project_choices,
            'push_percent' => $this->push_percent,
            'status_text' => $this->status_text,
            'svc_root' => $this->svc_root,
            'svn_root' => $this->svn_root,
            'tfvc_project' => $this->tfvc_project,
            'use_lfs' => $this->use_lfs,
        ];
    }
}
