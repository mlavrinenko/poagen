<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class WebhookRegistryPackagePublishedRegistry_packagePackage_versionNpm_metadata implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'author' => ['author', null],
        'bin' => ['bin', null],
        'bugs' => ['bugs', null],
        'commit_oid' => ['commit_oid', null],
        'contributors' => ['contributors', ['list', null]],
        'cpu' => ['cpu', ['list', null]],
        'deleted_by_id' => ['deleted_by_id', null],
        'dependencies' => ['dependencies', null],
        'description' => ['description', null],
        'dev_dependencies' => ['dev_dependencies', null],
        'directories' => ['directories', null],
        'dist' => ['dist', null],
        'engines' => ['engines', null],
        'files' => ['files', ['list', null]],
        'git_head' => ['git_head', null],
        'has_shrinkwrap' => ['has_shrinkwrap', null],
        'homepage' => ['homepage', null],
        'id' => ['id', null],
        'installation_command' => ['installation_command', null],
        'keywords' => ['keywords', ['list', null]],
        'license' => ['license', null],
        'main' => ['main', null],
        'maintainers' => ['maintainers', ['list', null]],
        'man' => ['man', null],
        'name' => ['name', null],
        'node_version' => ['node_version', null],
        'npm_user' => ['npm_user', null],
        'npm_version' => ['npm_version', null],
        'optional_dependencies' => ['optional_dependencies', null],
        'os' => ['os', ['list', null]],
        'peer_dependencies' => ['peer_dependencies', null],
        'published_via_actions' => ['published_via_actions', null],
        'readme' => ['readme', null],
        'release_id' => ['release_id', null],
        'repository' => ['repository', null],
        'scripts' => ['scripts', null],
        'version' => ['version', null],
    ];

    /**
     * @param ?mixed $author
     * @param ?array<string, mixed> $bin
     * @param ?mixed $bugs
     * @param ?list<string> $contributors
     * @param ?list<string> $cpu
     * @param ?array<string, mixed> $dependencies
     * @param ?array<string, mixed> $dev_dependencies
     * @param ?mixed $directories
     * @param ?mixed $dist
     * @param ?array<string, mixed> $engines
     * @param ?list<string> $files
     * @param ?list<string> $keywords
     * @param ?list<string> $maintainers
     * @param ?array<string, mixed> $man
     * @param ?array<string, mixed> $optional_dependencies
     * @param ?list<string> $os
     * @param ?array<string, mixed> $peer_dependencies
     * @param ?mixed $repository
     * @param ?array<string, mixed> $scripts
     */
    public function __construct(
        public $author = null,
        public ?array $bin = null,
        public $bugs = null,
        public ?string $commit_oid = null,
        public ?array $contributors = null,
        public ?array $cpu = null,
        public ?int $deleted_by_id = null,
        public ?array $dependencies = null,
        public ?string $description = null,
        public ?array $dev_dependencies = null,
        public $directories = null,
        public $dist = null,
        public ?array $engines = null,
        public ?array $files = null,
        public ?string $git_head = null,
        public ?bool $has_shrinkwrap = null,
        public ?string $homepage = null,
        public ?string $id = null,
        public ?string $installation_command = null,
        public ?array $keywords = null,
        public ?string $license = null,
        public ?string $main = null,
        public ?array $maintainers = null,
        public ?array $man = null,
        public ?string $name = null,
        public ?string $node_version = null,
        public ?string $npm_user = null,
        public ?string $npm_version = null,
        public ?array $optional_dependencies = null,
        public ?array $os = null,
        public ?array $peer_dependencies = null,
        public ?bool $published_via_actions = null,
        public ?string $readme = null,
        public ?int $release_id = null,
        public $repository = null,
        public ?array $scripts = null,
        public ?string $version = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'author' => $this->author,
            'bin' => $this->bin,
            'bugs' => $this->bugs,
            'commit_oid' => $this->commit_oid,
            'contributors' => $this->contributors,
            'cpu' => $this->cpu,
            'deleted_by_id' => $this->deleted_by_id,
            'dependencies' => $this->dependencies,
            'description' => $this->description,
            'dev_dependencies' => $this->dev_dependencies,
            'directories' => $this->directories,
            'dist' => $this->dist,
            'engines' => $this->engines,
            'files' => $this->files,
            'git_head' => $this->git_head,
            'has_shrinkwrap' => $this->has_shrinkwrap,
            'homepage' => $this->homepage,
            'id' => $this->id,
            'installation_command' => $this->installation_command,
            'keywords' => $this->keywords,
            'license' => $this->license,
            'main' => $this->main,
            'maintainers' => $this->maintainers,
            'man' => $this->man,
            'name' => $this->name,
            'node_version' => $this->node_version,
            'npm_user' => $this->npm_user,
            'npm_version' => $this->npm_version,
            'optional_dependencies' => $this->optional_dependencies,
            'os' => $this->os,
            'peer_dependencies' => $this->peer_dependencies,
            'published_via_actions' => $this->published_via_actions,
            'readme' => $this->readme,
            'release_id' => $this->release_id,
            'repository' => $this->repository,
            'scripts' => $this->scripts,
            'version' => $this->version,
        ];
    }
}
