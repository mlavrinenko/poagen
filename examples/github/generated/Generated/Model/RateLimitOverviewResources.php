<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class RateLimitOverviewResources
{
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
}
