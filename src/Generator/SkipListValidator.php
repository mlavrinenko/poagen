<?php

declare(strict_types=1);

namespace Mlavrinenko\Paogen\Generator;

use cebe\openapi\spec\OpenApi;
use cebe\openapi\spec\PathItem;
use Mlavrinenko\Paogen\Generator\Emit\ComponentCatalog;
use Mlavrinenko\Paogen\Generator\Emit\SkippedComponent;
use Mlavrinenko\Paogen\Generator\Emit\SkippedOperation;

use function sprintf;

/**
 * Cross-checks the operations/components the generator could not represent
 * this run against {@see Profile::$skip}.
 *
 * Every problem is either covered by a matching skip entry (omitted from
 * the output, run proceeds) or reported as a failure (the run aborts). A
 * skip entry that no longer matches any problem, or that names an
 * operation id / component absent from the schema entirely, is itself a
 * failure — a skip list that outlives its cause is the silent-success bug
 * this feature replaces, wearing a different hat.
 *
 * See abort-on-unrepresentable-constructs.
 */
final readonly class SkipListValidator
{
    /**
     * @param  array<string,string>   $skip               Profile::$skip
     * @param  list<SkippedOperation> $skippedOperations
     * @param  list<SkippedComponent> $skippedComponents
     * @return list<string>           failure lines; empty means the run may proceed
     */
    public function validate(
        OpenApi $openApi,
        ComponentCatalog $components,
        array $skip,
        array $skippedOperations,
        array $skippedComponents,
    ): array {
        $validTargets = array_fill_keys(
            [...$this->operationIds($openApi), ...array_keys($components->all())],
            true,
        );

        /** @var array<string,true> $problemTargets */
        $problemTargets = [];
        $failures = [];

        foreach ($skippedOperations as $operation) {
            if ($operation->operationId === '' || !isset($skip[$operation->operationId])) {
                $failures[] = $operation->format();

                continue;
            }

            $problemTargets[$operation->operationId] = true;
        }

        foreach ($skippedComponents as $component) {
            if (!isset($skip[$component->rawName])) {
                $failures[] = $component->reason;

                continue;
            }

            $problemTargets[$component->rawName] = true;
        }

        foreach (array_keys($skip) as $target) {
            if (!isset($validTargets[$target])) {
                $failures[] = sprintf(
                    "Profile::\$skip['%s'] names an operation id or component absent from the schema — remove this entry.",
                    $target,
                );

                continue;
            }

            if (!isset($problemTargets[$target])) {
                $failures[] = sprintf(
                    "Profile::\$skip['%s'] is stale — it now generates cleanly; delete this entry.",
                    $target,
                );
            }
        }

        return $failures;
    }

    /**
     * @return list<string> every non-empty operationId declared anywhere in
     *                      the document, regardless of whether paogen can
     *                      represent it
     */
    private function operationIds(OpenApi $openApi): array
    {
        $paths = $openApi->paths;

        if ($paths === null) {
            return [];
        }

        $ids = [];

        foreach ($paths as $pathItem) {
            if (!$pathItem instanceof PathItem) {
                continue;
            }

            foreach ($pathItem->getOperations() as $operation) {
                $id = (string) ($operation->operationId ?? '');

                if ($id !== '') {
                    $ids[] = $id;
                }
            }
        }

        return $ids;
    }
}
