<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use function sprintf;

/**
 * Diagnostic record for an OpenAPI operation that the generator chose
 * not to emit. Surfaced through {@see GenerationPlan} so the CLI can
 * tell the user *which* ops did not make it into the client and *why*,
 * instead of dropping them on the floor.
 *
 * @internal
 */
final readonly class SkippedOperation
{
    public const string REASON_MISSING_OPERATION_ID = 'operation has no operationId — poagen needs one to name '
        . 'a method and to reference the operation from Profile::$skip; add operationId to this operation in the schema';

    public function __construct(
        public string $httpMethod,
        public string $pathUri,
        public string $operationId,
        public string $reason,
    ) {}

    public function format(): string
    {
        $id = $this->operationId === '' ? '<missing operationId>' : $this->operationId;

        return sprintf('  %s %s (%s) — %s', strtoupper($this->httpMethod), $this->pathUri, $id, $this->reason);
    }
}
