<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\SecretScanningAlertResolutionWebhook;
use DateTimeImmutable;
use JsonSerializable;

final readonly class SecretScanningAlertWebhook implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'assigned_to' => ['assigned_to', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'closure_request_comment' => ['closure_request_comment', null],
        'closure_request_reviewer' => ['closure_request_reviewer', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'closure_request_reviewer_comment' => ['closure_request_reviewer_comment', null],
        'created_at' => ['created_at', \Acme\GitHub\Generated\Model\AlertCreatedAt::class],
        'html_url' => ['html_url', \Acme\GitHub\Generated\Model\AlertHtmlUrl::class],
        'locations_url' => ['locations_url', null],
        'multi_repo' => ['multi_repo', null],
        'number' => ['number', \Acme\GitHub\Generated\Model\AlertNumber::class],
        'provider' => ['provider', null],
        'provider_slug' => ['provider_slug', null],
        'publicly_leaked' => ['publicly_leaked', null],
        'push_protection_bypass_request_comment' => ['push_protection_bypass_request_comment', null],
        'push_protection_bypass_request_html_url' => ['push_protection_bypass_request_html_url', null],
        'push_protection_bypass_request_reviewer' => [
            'push_protection_bypass_request_reviewer',
            \Acme\GitHub\Generated\Model\NullableSimpleUser::class,
        ],
        'push_protection_bypass_request_reviewer_comment' => ['push_protection_bypass_request_reviewer_comment', null],
        'push_protection_bypassed' => ['push_protection_bypassed', null],
        'push_protection_bypassed_at' => ['push_protection_bypassed_at', ['datetime', null]],
        'push_protection_bypassed_by' => [
            'push_protection_bypassed_by',
            \Acme\GitHub\Generated\Model\NullableSimpleUser::class,
        ],
        'resolution' => ['resolution', ['enum', \Acme\GitHub\Generated\Enum\SecretScanningAlertResolutionWebhook::class]],
        'resolution_comment' => ['resolution_comment', null],
        'resolved_at' => ['resolved_at', ['datetime', null]],
        'resolved_by' => ['resolved_by', \Acme\GitHub\Generated\Model\NullableSimpleUser::class],
        'secret_type' => ['secret_type', null],
        'secret_type_display_name' => ['secret_type_display_name', null],
        'updated_at' => ['updated_at', \Acme\GitHub\Generated\Model\NullableAlertUpdatedAt::class],
        'url' => ['url', \Acme\GitHub\Generated\Model\AlertUrl::class],
        'validity' => ['validity', null],
    ];

    public function __construct(
        public ?NullableSimpleUser $assigned_to = null,
        public ?string $closure_request_comment = null,
        public ?NullableSimpleUser $closure_request_reviewer = null,
        public ?string $closure_request_reviewer_comment = null,
        public ?AlertCreatedAt $created_at = null,
        public ?AlertHtmlUrl $html_url = null,
        public ?string $locations_url = null,
        public ?bool $multi_repo = null,
        public ?AlertNumber $number = null,
        public ?string $provider = null,
        public ?string $provider_slug = null,
        public ?bool $publicly_leaked = null,
        public ?string $push_protection_bypass_request_comment = null,
        public ?string $push_protection_bypass_request_html_url = null,
        public ?NullableSimpleUser $push_protection_bypass_request_reviewer = null,
        public ?string $push_protection_bypass_request_reviewer_comment = null,
        public ?bool $push_protection_bypassed = null,
        public ?DateTimeImmutable $push_protection_bypassed_at = null,
        public ?NullableSimpleUser $push_protection_bypassed_by = null,
        public ?SecretScanningAlertResolutionWebhook $resolution = null,
        public ?string $resolution_comment = null,
        public ?DateTimeImmutable $resolved_at = null,
        public ?NullableSimpleUser $resolved_by = null,
        public ?string $secret_type = null,
        public ?string $secret_type_display_name = null,
        public ?NullableAlertUpdatedAt $updated_at = null,
        public ?AlertUrl $url = null,
        public ?string $validity = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'assigned_to' => $this->assigned_to,
            'closure_request_comment' => $this->closure_request_comment,
            'closure_request_reviewer' => $this->closure_request_reviewer,
            'closure_request_reviewer_comment' => $this->closure_request_reviewer_comment,
            'created_at' => $this->created_at,
            'html_url' => $this->html_url,
            'locations_url' => $this->locations_url,
            'multi_repo' => $this->multi_repo,
            'number' => $this->number,
            'provider' => $this->provider,
            'provider_slug' => $this->provider_slug,
            'publicly_leaked' => $this->publicly_leaked,
            'push_protection_bypass_request_comment' => $this->push_protection_bypass_request_comment,
            'push_protection_bypass_request_html_url' => $this->push_protection_bypass_request_html_url,
            'push_protection_bypass_request_reviewer' => $this->push_protection_bypass_request_reviewer,
            'push_protection_bypass_request_reviewer_comment' => $this->push_protection_bypass_request_reviewer_comment,
            'push_protection_bypassed' => $this->push_protection_bypassed,
            'push_protection_bypassed_at' => $this->push_protection_bypassed_at?->format(\DateTimeInterface::RFC3339),
            'push_protection_bypassed_by' => $this->push_protection_bypassed_by,
            'resolution' => $this->resolution,
            'resolution_comment' => $this->resolution_comment,
            'resolved_at' => $this->resolved_at?->format(\DateTimeInterface::RFC3339),
            'resolved_by' => $this->resolved_by,
            'secret_type' => $this->secret_type,
            'secret_type_display_name' => $this->secret_type_display_name,
            'updated_at' => $this->updated_at,
            'url' => $this->url,
            'validity' => $this->validity,
        ];
    }
}
