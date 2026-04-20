<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use DateTimeImmutable;

final readonly class CodeSecurityConfiguration
{
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
}
