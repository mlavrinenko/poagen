<?php

declare(strict_types=1);

namespace Acme\GitHub\Generated\Model;

use Acme\GitHub\Generated\Enum\CodeScanningAutofixStatus;
use JsonSerializable;

final readonly class CodeScanningAutofix implements JsonSerializable
{
    /**
     * Paogen marshal/unmarshal contract — phpName => [wireKey, shape]. See ADR-007.
     * @var array<string, array{0: string, 1: null|class-string|array{0: string, 1: null|class-string}|array{0: string, 1: list<class-string>, 2: ?string}}>
     */
    public const array PROPERTY_MAP = [
        'description' => ['description', \Acme\GitHub\Generated\Model\CodeScanningAutofixDescription::class],
        'started_at' => ['started_at', \Acme\GitHub\Generated\Model\CodeScanningAutofixStartedAt::class],
        'status' => ['status', ['enum', \Acme\GitHub\Generated\Enum\CodeScanningAutofixStatus::class]],
    ];

    public function __construct(
        public CodeScanningAutofixDescription $description,
        public CodeScanningAutofixStartedAt $started_at,
        public CodeScanningAutofixStatus $status,
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'description' => $this->description,
            'started_at' => $this->started_at,
            'status' => $this->status,
        ];
    }
}
