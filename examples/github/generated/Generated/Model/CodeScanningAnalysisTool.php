<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use JsonSerializable;

final readonly class CodeScanningAnalysisTool implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'guid' => ['guid', \Acme\GitHub\Generated\Model\CodeScanningAnalysisToolGuid::class],
        'name' => ['name', \Acme\GitHub\Generated\Model\CodeScanningAnalysisToolName::class],
        'version' => ['version', \Acme\GitHub\Generated\Model\CodeScanningAnalysisToolVersion::class],
    ];

    public function __construct(
        public ?CodeScanningAnalysisToolGuid $guid = null,
        public ?CodeScanningAnalysisToolName $name = null,
        public ?CodeScanningAnalysisToolVersion $version = null,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'guid' => $this->guid,
            'name' => $this->name,
            'version' => $this->version,
        ];
    }
}
