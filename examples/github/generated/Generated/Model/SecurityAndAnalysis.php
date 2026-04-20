<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

final readonly class SecurityAndAnalysis
{
    public function __construct(
        public ?SecurityAndAnalysisAdvanced_security $advanced_security = null,
        public ?SecurityAndAnalysisCode_security $code_security = null,
        public ?SecurityAndAnalysisDependabot_security_updates $dependabot_security_updates = null,
        public ?SecurityAndAnalysisSecret_scanning $secret_scanning = null,
        public ?SecurityAndAnalysisSecret_scanning_ai_detection $secret_scanning_ai_detection = null,
        public ?SecurityAndAnalysisSecret_scanning_delegated_alert_dismissal $secret_scanning_delegated_alert_dismissal = null,
        public ?SecurityAndAnalysisSecret_scanning_delegated_bypass $secret_scanning_delegated_bypass = null,
        public ?SecurityAndAnalysisSecret_scanning_delegated_bypass_options $secret_scanning_delegated_bypass_options = null,
        public ?SecurityAndAnalysisSecret_scanning_non_provider_patterns $secret_scanning_non_provider_patterns = null,
        public ?SecurityAndAnalysisSecret_scanning_push_protection $secret_scanning_push_protection = null,
    ) {
    }
}
