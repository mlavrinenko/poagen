<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class SecurityAndAnalysis implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'advanced_security' => [
            'advanced_security',
            \Acme\GitHub\Generated\Model\SecurityAndAnalysisAdvanced_security::class,
        ],
        'code_security' => ['code_security', \Acme\GitHub\Generated\Model\SecurityAndAnalysisCode_security::class],
        'dependabot_security_updates' => [
            'dependabot_security_updates',
            \Acme\GitHub\Generated\Model\SecurityAndAnalysisDependabot_security_updates::class,
        ],
        'secret_scanning' => ['secret_scanning', \Acme\GitHub\Generated\Model\SecurityAndAnalysisSecret_scanning::class],
        'secret_scanning_ai_detection' => [
            'secret_scanning_ai_detection',
            \Acme\GitHub\Generated\Model\SecurityAndAnalysisSecret_scanning_ai_detection::class,
        ],
        'secret_scanning_delegated_alert_dismissal' => [
            'secret_scanning_delegated_alert_dismissal',
            \Acme\GitHub\Generated\Model\SecurityAndAnalysisSecret_scanning_delegated_alert_dismissal::class,
        ],
        'secret_scanning_delegated_bypass' => [
            'secret_scanning_delegated_bypass',
            \Acme\GitHub\Generated\Model\SecurityAndAnalysisSecret_scanning_delegated_bypass::class,
        ],
        'secret_scanning_delegated_bypass_options' => [
            'secret_scanning_delegated_bypass_options',
            \Acme\GitHub\Generated\Model\SecurityAndAnalysisSecret_scanning_delegated_bypass_options::class,
        ],
        'secret_scanning_non_provider_patterns' => [
            'secret_scanning_non_provider_patterns',
            \Acme\GitHub\Generated\Model\SecurityAndAnalysisSecret_scanning_non_provider_patterns::class,
        ],
        'secret_scanning_push_protection' => [
            'secret_scanning_push_protection',
            \Acme\GitHub\Generated\Model\SecurityAndAnalysisSecret_scanning_push_protection::class,
        ],
    ];

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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'advanced_security' => $this->advanced_security,
            'code_security' => $this->code_security,
            'dependabot_security_updates' => $this->dependabot_security_updates,
            'secret_scanning' => $this->secret_scanning,
            'secret_scanning_ai_detection' => $this->secret_scanning_ai_detection,
            'secret_scanning_delegated_alert_dismissal' => $this->secret_scanning_delegated_alert_dismissal,
            'secret_scanning_delegated_bypass' => $this->secret_scanning_delegated_bypass,
            'secret_scanning_delegated_bypass_options' => $this->secret_scanning_delegated_bypass_options,
            'secret_scanning_non_provider_patterns' => $this->secret_scanning_non_provider_patterns,
            'secret_scanning_push_protection' => $this->secret_scanning_push_protection,
        ];
    }
}
