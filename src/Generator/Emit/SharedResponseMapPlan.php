<?php

declare(strict_types=1);

namespace Poagen\Generator\Generator\Emit;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;
use Nette\PhpGenerator\PhpNamespace;
use Poagen\Generator\Generator\Profile;
use Poagen\Generator\Generator\ResponseMapGroups;

use function sprintf;
use function trim;

/**
 * Which operations `Profile::$responseMaps` declared to share one
 * `StatusResponseMap`, resolved against the document.
 *
 * The plan is empty unless a consumer wrote a group, and an empty plan is
 * invisible: {@see OperationEmitter} falls back to the inline
 * `ResponseType::envelope(...)` it has always emitted, and
 * {@see SharedResponseMapEmitter} writes no file. A consumer who wants none
 * of this pays exactly nothing for it, byte for byte.
 *
 * This is the document-dependent half of the field's validation — the half
 * {@see ResponseMapGroups} cannot answer without a document, and so the half
 * that joins the collected failure pass rather than aborting on its own:
 *
 * - an operation id the document does not carry, told apart from
 * - an operation the run refuses, which has no response map to share, and
 * - a group whose members' maps are not in fact identical, named through
 *   {@see EnvelopeFingerprint}.
 *
 * Every member is compared against the first rather than every pair against
 * every other, exactly as {@see InlineModelMergeValidator} does: agreeing
 * with the first is transitive across a group that all agrees, and the first
 * disagreement is what the message needs to name.
 *
 * @internal
 */
final readonly class SharedResponseMapPlan
{
    /**
     * @param string                      $holder       FQCN of the emitted holder class, empty when the plan is empty
     * @param array<string,string>        $byOperation  raw operation id → the declaration it calls
     * @param array<string,EnvelopeSpec>  $declarations declaration name → the one envelope it stands for
     * @param array<string, list<string>> $members      declaration name → the operations sharing it
     * @param list<string>                $failures     collected for the run's single report
     */
    public function __construct(
        private string $holder = '',
        private array $byOperation = [],
        private array $declarations = [],
        private array $members = [],
        public array $failures = [],
    ) {}

    /**
     * @param array<string, list<string>> $groups Profile::$responseMaps, already past {@see ResponseMapGroups}
     */
    public static function build(
        array $groups,
        OpenApi $openApi,
        InlinePayloadCatalog $payloads,
        string $clientNamespace,
        string $modelNamespace,
    ): self {
        if ($groups === []) {
            return new self();
        }

        $declared = self::declaredIds($openApi);
        $byOperation = [];
        $declarations = [];
        $members = [];
        $failures = [];

        foreach ($groups as $name => $operationIds) {
            $resolved = self::resolve($name, $operationIds, $declared, $payloads, $modelNamespace);
            $failures = [...$failures, ...$resolved['failures']];
            $envelope = $resolved['envelope'];
            if ($resolved['failures'] !== []) {
                continue;
            }
            if (!$envelope instanceof EnvelopeSpec) {
                continue;
            }

            $declarations[$name] = $envelope;
            $members[$name] = $operationIds;

            foreach ($operationIds as $operationId) {
                $byOperation[$operationId] = $name;
            }
        }

        return new self(
            trim($clientNamespace, '\\') . '\\' . SharedResponseMapEmitter::CLASS_NAME,
            $byOperation,
            $declarations,
            $members,
            $failures,
        );
    }

    public function isEmpty(): bool
    {
        return $this->declarations === [];
    }

    /**
     * The call an operation in a group emits in place of its own map literal,
     * or `null` for every operation no group named — which is every operation
     * in a profile that declared none.
     */
    public function expressionFor(PhpNamespace $namespace, string $rawOperationId): ?string
    {
        $name = $this->byOperation[$rawOperationId] ?? null;

        if ($name === null) {
            return null;
        }

        return $namespace->simplifyName($this->holder) . '::' . $name . '()';
    }

    /**
     * @return array<string,EnvelopeSpec>
     */
    public function declarations(): array
    {
        return $this->declarations;
    }

    /**
     * @return list<string> the operations sharing one declaration, in profile order
     */
    public function membersOf(string $name): array
    {
        return $this->members[$name] ?? [];
    }

    /**
     * @param  list<string>                                        $operationIds
     * @param  array<string,true>                                  $declared
     * @return array{envelope: EnvelopeSpec|null, failures: list<string>}
     */
    private static function resolve(
        string $name,
        array $operationIds,
        array $declared,
        InlinePayloadCatalog $payloads,
        string $modelNamespace,
    ): array {
        $failures = [];
        $first = null;
        $firstId = '';

        foreach ($operationIds as $operationId) {
            $envelope = $payloads->envelopeFor($operationId);

            if (!$envelope instanceof EnvelopeSpec) {
                $failures[] = self::unresolved($name, $operationId, isset($declared[$operationId]));

                continue;
            }

            if (!$first instanceof EnvelopeSpec) {
                $first = $envelope;
                $firstId = $operationId;

                continue;
            }

            $difference = EnvelopeFingerprint::firstDifference($first, $envelope, $modelNamespace);

            if ($difference !== null) {
                $failures[] = sprintf(
                    "Profile::\$responseMaps['%s'] groups operations whose response maps are not identical: '%s' "
                        . "and '%s' differ on %s. A shared declaration has to be one declaration — split the group, "
                        . 'or reconcile the difference in the document.',
                    $name,
                    $firstId,
                    $operationId,
                    $difference,
                );
            }
        }

        return ['envelope' => $first, 'failures' => $failures];
    }

    private static function unresolved(string $name, string $operationId, bool $inDocument): string
    {
        if (!$inDocument) {
            return sprintf(
                "Profile::\$responseMaps['%s'] names the operation id '%s', which is absent from the schema — "
                    . 'remove this entry, or point it at the operation id the vendor now uses.',
                $name,
                $operationId,
            );
        }

        return sprintf(
            "Profile::\$responseMaps['%s'] names the operation id '%s', whose responses this run does not emit — a "
                . 'skipped or refused operation has no response map to share. Drop it from this group.',
            $name,
            $operationId,
        );
    }

    /**
     * @return array<string,true> every operation id the document declares
     */
    private static function declaredIds(OpenApi $openApi): array
    {
        $ids = [];

        foreach ($openApi->paths ?? [] as $pathItem) {
            if ($pathItem instanceof PathItem) {
                foreach ($pathItem->getOperations() as $operation) {
                    $ids[(string) ($operation->operationId ?? '')] = true;
                }
            }
        }

        unset($ids['']);

        return $ids;
    }
}
