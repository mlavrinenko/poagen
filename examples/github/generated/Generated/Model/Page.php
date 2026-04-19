<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class Page implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'cname' => ['cname', null],
        'custom_404' => ['custom_404', null],
        'public' => ['public', null],
        'status' => ['status', null],
        'url' => ['url', null],
        'build_type' => ['build_type', null],
        'html_url' => ['html_url', null],
        'https_certificate' => ['https_certificate', \Acme\GitHub\Generated\Model\PagesHttpsCertificate::class],
        'https_enforced' => ['https_enforced', null],
        'pending_domain_unverified_at' => ['pending_domain_unverified_at', ['datetime', null]],
        'protected_domain_state' => ['protected_domain_state', null],
        'source' => ['source', \Acme\GitHub\Generated\Model\PagesSourceHash::class],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'cname' => $this->cname,
            'custom_404' => $this->custom_404,
            'public' => $this->public,
            'status' => $this->status,
            'url' => $this->url,
            'build_type' => $this->build_type,
            'html_url' => $this->html_url,
            'https_certificate' => $this->https_certificate,
            'https_enforced' => $this->https_enforced,
            'pending_domain_unverified_at' => $this->pending_domain_unverified_at?->format(\DateTimeInterface::RFC3339),
            'protected_domain_state' => $this->protected_domain_state,
            'source' => $this->source,
        ];
    }
}
