<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CodeScanningAlertState;
use JsonSerializable;

final readonly class CodeScanningAlertInstance implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'analysis_key' => ['analysis_key', \Acme\GitHub\Generated\Model\CodeScanningAnalysisAnalysisKey::class],
        'category' => ['category', \Acme\GitHub\Generated\Model\CodeScanningAnalysisCategory::class],
        'classifications' => [
            'classifications',
            ['list', \Acme\GitHub\Generated\Model\CodeScanningAlertClassification::class],
        ],
        'commit_sha' => ['commit_sha', null],
        'environment' => ['environment', \Acme\GitHub\Generated\Model\CodeScanningAlertEnvironment::class],
        'html_url' => ['html_url', null],
        'location' => ['location', \Acme\GitHub\Generated\Model\CodeScanningAlertLocation::class],
        'message' => ['message', \Acme\GitHub\Generated\Model\CodeScanningAlertInstanceMessage::class],
        'ref' => ['ref', \Acme\GitHub\Generated\Model\CodeScanningRef::class],
        'state' => ['state', ['enum', \Acme\GitHub\Generated\Enum\CodeScanningAlertState::class]],
    ];

    /**
     * @param ?list<\Acme\GitHub\Generated\Enum\CodeScanningAlertClassification> $classifications
     */
    public function __construct(
        public ?CodeScanningAnalysisAnalysisKey $analysis_key = null,
        public ?CodeScanningAnalysisCategory $category = null,
        public ?array $classifications = null,
        public ?string $commit_sha = null,
        public ?CodeScanningAlertEnvironment $environment = null,
        public ?string $html_url = null,
        public ?CodeScanningAlertLocation $location = null,
        public ?CodeScanningAlertInstanceMessage $message = null,
        public ?CodeScanningRef $ref = null,
        public ?CodeScanningAlertState $state = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'analysis_key' => $this->analysis_key,
            'category' => $this->category,
            'classifications' => $this->classifications,
            'commit_sha' => $this->commit_sha,
            'environment' => $this->environment,
            'html_url' => $this->html_url,
            'location' => $this->location,
            'message' => $this->message,
            'ref' => $this->ref,
            'state' => $this->state,
        ];
    }
}
