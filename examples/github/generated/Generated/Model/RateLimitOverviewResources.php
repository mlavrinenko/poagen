<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class RateLimitOverviewResources implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'core' => ['core', \Acme\GitHub\Generated\Model\RateLimit::class],
        'search' => ['search', \Acme\GitHub\Generated\Model\RateLimit::class],
        'actions_runner_registration' => ['actions_runner_registration', \Acme\GitHub\Generated\Model\RateLimit::class],
        'code_scanning_autofix' => ['code_scanning_autofix', \Acme\GitHub\Generated\Model\RateLimit::class],
        'code_scanning_upload' => ['code_scanning_upload', \Acme\GitHub\Generated\Model\RateLimit::class],
        'code_search' => ['code_search', \Acme\GitHub\Generated\Model\RateLimit::class],
        'dependency_sbom' => ['dependency_sbom', \Acme\GitHub\Generated\Model\RateLimit::class],
        'dependency_snapshots' => ['dependency_snapshots', \Acme\GitHub\Generated\Model\RateLimit::class],
        'graphql' => ['graphql', \Acme\GitHub\Generated\Model\RateLimit::class],
        'integration_manifest' => ['integration_manifest', \Acme\GitHub\Generated\Model\RateLimit::class],
        'scim' => ['scim', \Acme\GitHub\Generated\Model\RateLimit::class],
        'source_import' => ['source_import', \Acme\GitHub\Generated\Model\RateLimit::class],
    ];

    public function __construct(
        public RateLimit $core,
        public RateLimit $search,
        public ?RateLimit $actions_runner_registration = null,
        public ?RateLimit $code_scanning_autofix = null,
        public ?RateLimit $code_scanning_upload = null,
        public ?RateLimit $code_search = null,
        public ?RateLimit $dependency_sbom = null,
        public ?RateLimit $dependency_snapshots = null,
        public ?RateLimit $graphql = null,
        public ?RateLimit $integration_manifest = null,
        public ?RateLimit $scim = null,
        public ?RateLimit $source_import = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'core' => $this->core,
            'search' => $this->search,
            'actions_runner_registration' => $this->actions_runner_registration,
            'code_scanning_autofix' => $this->code_scanning_autofix,
            'code_scanning_upload' => $this->code_scanning_upload,
            'code_search' => $this->code_search,
            'dependency_sbom' => $this->dependency_sbom,
            'dependency_snapshots' => $this->dependency_snapshots,
            'graphql' => $this->graphql,
            'integration_manifest' => $this->integration_manifest,
            'scim' => $this->scim,
            'source_import' => $this->source_import,
        ];
    }
}
