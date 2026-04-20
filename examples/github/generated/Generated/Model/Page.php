<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class Page
{
    public function __construct(
        public ?string $cname = null,
        public bool $custom_404,
        public bool $public,
        public ?string $status = null,
        public string $url,
        public ?string $build_type = null,
        public ?string $html_url = null,
        public ?PagesHttpsCertificate $https_certificate = null,
        public ?bool $https_enforced = null,
        public ?DateTimeImmutable $pending_domain_unverified_at = null,
        public ?string $protected_domain_state = null,
        public ?PagesSourceHash $source = null,
    ) {
    }
}
