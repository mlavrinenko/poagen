<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;
use JsonSerializable;

final readonly class CodeSecurityConfiguration implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'advanced_security' => ['advanced_security', null],
        'code_scanning_default_setup' => ['code_scanning_default_setup', null],
        'code_scanning_default_setup_options' => [
            'code_scanning_default_setup_options',
            \Acme\GitHub\Generated\Model\CodeSecurityConfigurationCode_scanning_default_setup_options::class,
        ],
        'code_scanning_delegated_alert_dismissal' => ['code_scanning_delegated_alert_dismissal', null],
        'code_scanning_options' => [
            'code_scanning_options',
            \Acme\GitHub\Generated\Model\CodeSecurityConfigurationCode_scanning_options::class,
        ],
        'created_at' => ['created_at', ['datetime', null]],
        'dependabot_alerts' => ['dependabot_alerts', null],
        'dependabot_delegated_alert_dismissal' => ['dependabot_delegated_alert_dismissal', null],
        'dependabot_security_updates' => ['dependabot_security_updates', null],
        'dependency_graph' => ['dependency_graph', null],
        'dependency_graph_autosubmit_action' => ['dependency_graph_autosubmit_action', null],
        'dependency_graph_autosubmit_action_options' => [
            'dependency_graph_autosubmit_action_options',
            \Acme\GitHub\Generated\Model\CodeSecurityConfigurationDependency_graph_autosubmit_action_options::class,
        ],
        'description' => ['description', null],
        'enforcement' => ['enforcement', null],
        'html_url' => ['html_url', null],
        'id' => ['id', null],
        'name' => ['name', null],
        'private_vulnerability_reporting' => ['private_vulnerability_reporting', null],
        'secret_scanning' => ['secret_scanning', null],
        'secret_scanning_delegated_alert_dismissal' => ['secret_scanning_delegated_alert_dismissal', null],
        'secret_scanning_delegated_bypass' => ['secret_scanning_delegated_bypass', null],
        'secret_scanning_delegated_bypass_options' => [
            'secret_scanning_delegated_bypass_options',
            \Acme\GitHub\Generated\Model\CodeSecurityConfigurationSecret_scanning_delegated_bypass_options::class,
        ],
        'secret_scanning_extended_metadata' => ['secret_scanning_extended_metadata', null],
        'secret_scanning_generic_secrets' => ['secret_scanning_generic_secrets', null],
        'secret_scanning_non_provider_patterns' => ['secret_scanning_non_provider_patterns', null],
        'secret_scanning_push_protection' => ['secret_scanning_push_protection', null],
        'secret_scanning_validity_checks' => ['secret_scanning_validity_checks', null],
        'target_type' => ['target_type', null],
        'updated_at' => ['updated_at', ['datetime', null]],
        'url' => ['url', null],
    ];

    public function __construct(
        public ?string $advanced_security = null,
        public ?string $code_scanning_default_setup = null,
        public ?CodeSecurityConfigurationCode_scanning_default_setup_options $code_scanning_default_setup_options = null,
        public ?string $code_scanning_delegated_alert_dismissal = null,
        public ?CodeSecurityConfigurationCode_scanning_options $code_scanning_options = null,
        public ?DateTimeImmutable $created_at = null,
        public ?string $dependabot_alerts = null,
        public ?string $dependabot_delegated_alert_dismissal = null,
        public ?string $dependabot_security_updates = null,
        public ?string $dependency_graph = null,
        public ?string $dependency_graph_autosubmit_action = null,
        public ?CodeSecurityConfigurationDependency_graph_autosubmit_action_options $dependency_graph_autosubmit_action_options = null,
        public ?string $description = null,
        public ?string $enforcement = null,
        public ?string $html_url = null,
        public ?int $id = null,
        public ?string $name = null,
        public ?string $private_vulnerability_reporting = null,
        public ?string $secret_scanning = null,
        public ?string $secret_scanning_delegated_alert_dismissal = null,
        public ?string $secret_scanning_delegated_bypass = null,
        public ?CodeSecurityConfigurationSecret_scanning_delegated_bypass_options $secret_scanning_delegated_bypass_options = null,
        public ?string $secret_scanning_extended_metadata = null,
        public ?string $secret_scanning_generic_secrets = null,
        public ?string $secret_scanning_non_provider_patterns = null,
        public ?string $secret_scanning_push_protection = null,
        public ?string $secret_scanning_validity_checks = null,
        public ?string $target_type = null,
        public ?DateTimeImmutable $updated_at = null,
        public ?string $url = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'advanced_security' => $this->advanced_security,
            'code_scanning_default_setup' => $this->code_scanning_default_setup,
            'code_scanning_default_setup_options' => $this->code_scanning_default_setup_options,
            'code_scanning_delegated_alert_dismissal' => $this->code_scanning_delegated_alert_dismissal,
            'code_scanning_options' => $this->code_scanning_options,
            'created_at' => $this->created_at?->format(\DateTimeInterface::RFC3339),
            'dependabot_alerts' => $this->dependabot_alerts,
            'dependabot_delegated_alert_dismissal' => $this->dependabot_delegated_alert_dismissal,
            'dependabot_security_updates' => $this->dependabot_security_updates,
            'dependency_graph' => $this->dependency_graph,
            'dependency_graph_autosubmit_action' => $this->dependency_graph_autosubmit_action,
            'dependency_graph_autosubmit_action_options' => $this->dependency_graph_autosubmit_action_options,
            'description' => $this->description,
            'enforcement' => $this->enforcement,
            'html_url' => $this->html_url,
            'id' => $this->id,
            'name' => $this->name,
            'private_vulnerability_reporting' => $this->private_vulnerability_reporting,
            'secret_scanning' => $this->secret_scanning,
            'secret_scanning_delegated_alert_dismissal' => $this->secret_scanning_delegated_alert_dismissal,
            'secret_scanning_delegated_bypass' => $this->secret_scanning_delegated_bypass,
            'secret_scanning_delegated_bypass_options' => $this->secret_scanning_delegated_bypass_options,
            'secret_scanning_extended_metadata' => $this->secret_scanning_extended_metadata,
            'secret_scanning_generic_secrets' => $this->secret_scanning_generic_secrets,
            'secret_scanning_non_provider_patterns' => $this->secret_scanning_non_provider_patterns,
            'secret_scanning_push_protection' => $this->secret_scanning_push_protection,
            'secret_scanning_validity_checks' => $this->secret_scanning_validity_checks,
            'target_type' => $this->target_type,
            'updated_at' => $this->updated_at?->format(\DateTimeInterface::RFC3339),
            'url' => $this->url,
        ];
    }
}
