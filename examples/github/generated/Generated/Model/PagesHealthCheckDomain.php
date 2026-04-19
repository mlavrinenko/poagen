<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class PagesHealthCheckDomain implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'caa_error' => ['caa_error', null],
        'dns_resolves' => ['dns_resolves', null],
        'enforces_https' => ['enforces_https', null],
        'has_cname_record' => ['has_cname_record', null],
        'has_mx_records_present' => ['has_mx_records_present', null],
        'host' => ['host', null],
        'https_error' => ['https_error', null],
        'is_a_record' => ['is_a_record', null],
        'is_apex_domain' => ['is_apex_domain', null],
        'is_cloudflare_ip' => ['is_cloudflare_ip', null],
        'is_cname_to_fastly' => ['is_cname_to_fastly', null],
        'is_cname_to_github_user_domain' => ['is_cname_to_github_user_domain', null],
        'is_cname_to_pages_dot_github_dot_com' => ['is_cname_to_pages_dot_github_dot_com', null],
        'is_fastly_ip' => ['is_fastly_ip', null],
        'is_https_eligible' => ['is_https_eligible', null],
        'is_non_github_pages_ip_present' => ['is_non_github_pages_ip_present', null],
        'is_old_ip_address' => ['is_old_ip_address', null],
        'is_pages_domain' => ['is_pages_domain', null],
        'is_pointed_to_github_pages_ip' => ['is_pointed_to_github_pages_ip', null],
        'is_proxied' => ['is_proxied', null],
        'is_served_by_pages' => ['is_served_by_pages', null],
        'is_valid' => ['is_valid', null],
        'is_valid_domain' => ['is_valid_domain', null],
        'nameservers' => ['nameservers', null],
        'reason' => ['reason', null],
        'responds_to_https' => ['responds_to_https', null],
        'should_be_a_record' => ['should_be_a_record', null],
        'uri' => ['uri', null],
    ];

    public function __construct(
        public ?string $caa_error = null,
        public ?bool $dns_resolves = null,
        public ?bool $enforces_https = null,
        public ?bool $has_cname_record = null,
        public ?bool $has_mx_records_present = null,
        public ?string $host = null,
        public ?string $https_error = null,
        public ?bool $is_a_record = null,
        public ?bool $is_apex_domain = null,
        public ?bool $is_cloudflare_ip = null,
        public ?bool $is_cname_to_fastly = null,
        public ?bool $is_cname_to_github_user_domain = null,
        public ?bool $is_cname_to_pages_dot_github_dot_com = null,
        public ?bool $is_fastly_ip = null,
        public ?bool $is_https_eligible = null,
        public ?bool $is_non_github_pages_ip_present = null,
        public ?bool $is_old_ip_address = null,
        public ?bool $is_pages_domain = null,
        public ?bool $is_pointed_to_github_pages_ip = null,
        public ?bool $is_proxied = null,
        public ?bool $is_served_by_pages = null,
        public ?bool $is_valid = null,
        public ?bool $is_valid_domain = null,
        public ?string $nameservers = null,
        public ?string $reason = null,
        public ?bool $responds_to_https = null,
        public ?bool $should_be_a_record = null,
        public ?string $uri = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'caa_error' => $this->caa_error,
            'dns_resolves' => $this->dns_resolves,
            'enforces_https' => $this->enforces_https,
            'has_cname_record' => $this->has_cname_record,
            'has_mx_records_present' => $this->has_mx_records_present,
            'host' => $this->host,
            'https_error' => $this->https_error,
            'is_a_record' => $this->is_a_record,
            'is_apex_domain' => $this->is_apex_domain,
            'is_cloudflare_ip' => $this->is_cloudflare_ip,
            'is_cname_to_fastly' => $this->is_cname_to_fastly,
            'is_cname_to_github_user_domain' => $this->is_cname_to_github_user_domain,
            'is_cname_to_pages_dot_github_dot_com' => $this->is_cname_to_pages_dot_github_dot_com,
            'is_fastly_ip' => $this->is_fastly_ip,
            'is_https_eligible' => $this->is_https_eligible,
            'is_non_github_pages_ip_present' => $this->is_non_github_pages_ip_present,
            'is_old_ip_address' => $this->is_old_ip_address,
            'is_pages_domain' => $this->is_pages_domain,
            'is_pointed_to_github_pages_ip' => $this->is_pointed_to_github_pages_ip,
            'is_proxied' => $this->is_proxied,
            'is_served_by_pages' => $this->is_served_by_pages,
            'is_valid' => $this->is_valid,
            'is_valid_domain' => $this->is_valid_domain,
            'nameservers' => $this->nameservers,
            'reason' => $this->reason,
            'responds_to_https' => $this->responds_to_https,
            'should_be_a_record' => $this->should_be_a_record,
            'uri' => $this->uri,
        ];
    }
}
